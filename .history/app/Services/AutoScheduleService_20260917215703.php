<?php

namespace App\Services;

use App\Models\Kegiatan;
use App\Models\KegiatanPekerjaan;
use App\Models\Penugasan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AutoScheduleService
{
    public function generateForActivity(Kegiatan $activity): array
    {
        $warnings = [];
        $generated = [];

        $activity->load('jobRequirements.jobType');

        if ($activity->jobRequirements->isEmpty()) {
            return ['activity' => $activity, 'generated_assignments' => [], 'number_required' => 0, 'number_assigned' => 0, 'warnings' => ['No job requirements exist for this activity.']];
        }

        DB::beginTransaction();

        try {
            foreach ($activity->jobRequirements as $requirement) {
                $required = (int) $requirement->jumlah_orang_dibutuhkan;
                $eligible = User::query()
                    ->where('role', 'anggota')
                    ->where('status_aktif', true)
                    ->whereHas('competencies', function ($query) use ($requirement) {
                        $query->where('jenis_pekerjaan_id', $requirement->jenis_pekerjaan_id);
                    })
                    ->with('competencies')
                    ->get();

                $filtered = $eligible->filter(function ($member) use ($requirement, $activity) {
                    $competency = $member->competencies->firstWhere('jenis_pekerjaan_id', $requirement->jenis_pekerjaan_id);
                    if (! $competency) {
                        return false;
                    }

                    $minimumLevel = $requirement->tingkat_kemampuan_minimal;
                    if (! $minimumLevel) {
                        return true;
                    }

                    $levels = ['pemula' => 1, 'menengah' => 2, 'mahir' => 3];
                    return $levels[$competency->tingkat_kemampuan] >= $levels[$minimumLevel];
                });

                $filtered = $filtered->reject(function ($member) use ($activity) {
                    return Penugasan::query()
                        ->where('anggota_id', $member->id)
                        ->where('status', '!=', 'cancelled')
                        ->whereHas('activityJobRequirement.activity', function ($query) use ($activity) {
                            $query->where('kegiatan_id', '!=', $activity->id)
                                ->whereDate('tanggal_mulai', '<=', $activity->tanggal_selesai)
                                ->whereDate('tanggal_selesai', '>=', $activity->tanggal_mulai);
                        })->exists();
                })->values();

                $filtered = $filtered->sortBy(function ($member) use ($activity, $requirement) {
                    $completedCount = Penugasan::query()
                        ->where('anggota_id', $member->id)
                        ->where('status', 'completed')
                        ->count();

                    $lastCompletedAt = Penugasan::query()
                        ->where('anggota_id', $member->id)
                        ->where('status', 'completed')
                        ->max('completed_at');

                    return [$completedCount, $lastCompletedAt ? Carbon::parse($lastCompletedAt)->timestamp : PHP_INT_MAX, $member->id];
                })->values();

                $selected = $filtered->take($required);

                if ($selected->count() < $required) {
                    $warnings[] = 'Insufficient eligible members for job type: '.$requirement->jobType->nama_pekerjaan.'. Required: '.$required.'; assigned: '.$selected->count().'.';
                    DB::rollBack();
                    return [
                        'activity' => $activity,
                        'generated_assignments' => [],
                        'number_required' => $this->countRequired($activity),
                        'number_assigned' => 0,
                        'warnings' => $warnings,
                    ];
                }

                foreach ($selected as $member) {
                    $assignment = Penugasan::create([
                        'kegiatan_pekerjaan_id' => $requirement->id,
                        'anggota_id' => $member->id,
                        'status' => 'assigned',
                        'sumber_penugasan' => 'otomatis',
                        'assigned_at' => now(),
                    ]);

                    $generated[] = $assignment;
                }
            }

            $activity->update([
                'status' => 'scheduled',
                'metode_penjadwalan' => 'otomatis',
            ]);

            DB::commit();

            return [
                'activity' => $activity->fresh('jobRequirements'),
                'generated_assignments' => $generated,
                'number_required' => $this->countRequired($activity),
                'number_assigned' => count($generated),
                'warnings' => $warnings,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function countRequired(Kegiatan $activity): int
    {
        return (int) $activity->jobRequirements()->sum('jumlah_orang_dibutuhkan');
    }
}
