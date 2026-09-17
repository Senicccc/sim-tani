<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use App\Models\Presensi;
use App\Models\Upah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function workReport(Request $request)
    {
        $query = Penugasan::query()->with(['activityJobRequirement.activity', 'activityJobRequirement.jobType']);
        if ($request->start_date) {
            $query->whereHas('activityJobRequirement.activity', fn ($q) => $q->whereDate('tanggal_mulai', '>=', $request->start_date));
        }
        if ($request->end_date) {
            $query->whereHas('activityJobRequirement.activity', fn ($q) => $q->whereDate('tanggal_selesai', '<=', $request->end_date));
        }

        return response()->json([
            'success' => true,
            'message' => 'Work report retrieved successfully.',
            'data' => [
                'total_assignments' => $query->count(),
                'completed_assignments' => (clone $query)->where('status', 'completed')->count(),
                'by_activity' => (clone $query)->select('kegiatan_pekerjaan_id', DB::raw('count(*) as total'))->groupBy('kegiatan_pekerjaan_id')->get(),
            ],
        ]);
    }

    public function attendanceReport(Request $request)
    {
        $query = Presensi::query();
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        return response()->json([
            'success' => true,
            'message' => 'Attendance report retrieved successfully.',
            'data' => [
                'total_attendance' => $query->count(),
                'present' => (clone $query)->where('status', 'hadir')->count(),
                'absent' => (clone $query)->where('status', 'tidak_hadir')->count(),
                'permit' => (clone $query)->where('status', 'izin')->count(),
            ],
        ]);
    }

    public function wageReport(Request $request)
    {
        $query = Upah::query();
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        return response()->json([
            'success' => true,
            'message' => 'Wage report retrieved successfully.',
            'data' => [
                'total_wage_value' => (clone $query)->sum('jumlah_upah'),
                'paid_wage_value' => (clone $query)->where('status_pembayaran', 'sudah_dibayar')->sum('jumlah_upah'),
                'unpaid_wage_value' => (clone $query)->where('status_pembayaran', 'belum_dibayar')->sum('jumlah_upah'),
            ],
        ]);
    }
}
