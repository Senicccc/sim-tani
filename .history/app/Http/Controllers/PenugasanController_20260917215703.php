<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\KegiatanPekerjaan;
use App\Models\Penugasan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PenugasanController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Assignments retrieved successfully.',
            'data' => Penugasan::with(['member', 'activityJobRequirement.jobType', 'activityJobRequirement.activity'])->latest()->get(),
        ]);
    }

    public function byActivity(Kegiatan $activity)
    {
        return response()->json([
            'success' => true,
            'message' => 'Activity assignments retrieved successfully.',
            'data' => Penugasan::with(['member', 'activityJobRequirement.jobType'])->whereRelation('activityJobRequirement', 'kegiatan_id', $activity->id)->get(),
        ]);
    }

    public function show(Penugasan $assignment)
    {
        return response()->json([
            'success' => true,
            'message' => 'Assignment retrieved successfully.',
            'data' => $assignment->load(['member', 'activityJobRequirement.jobType', 'activityJobRequirement.activity', 'attendance', 'wage']),
        ]);
    }

    public function update(Request $request, Penugasan $assignment)
    {
        $validated = $request->validate([
            'anggota_id' => ['sometimes', 'exists:users,id'],
            'status' => ['sometimes', Rule::in(['assigned', 'in_progress', 'waiting_verification', 'completed', 'cancelled'])],
            'sumber_penugasan' => ['sometimes', Rule::in(['otomatis', 'manual', 'hasil_perubahan'])],
            'catatan_penyelesaian' => ['nullable', 'string'],
        ]);

        $assignment->fill($validated);
        $assignment->sumber_penugasan = 'manual';
        $assignment->save();

        return response()->json([
            'success' => true,
            'message' => 'Assignment updated successfully.',
            'data' => $assignment->fresh()->load(['member', 'activityJobRequirement.jobType']),
        ]);
    }

    public function myTasks(Request $request)
    {
        $tasks = Penugasan::query()
            ->with(['activityJobRequirement.jobType', 'activityJobRequirement.activity'])
            ->where('anggota_id', $request->user()->id)
            ->latest('assigned_at')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Your tasks retrieved successfully.',
            'data' => $tasks,
        ]);
    }

    public function startTask(Request $request, Penugasan $assignment)
    {
        if ($assignment->anggota_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'You can only start your own task.'], 403);
        }

        if ($assignment->status !== 'assigned') {
            return response()->json(['success' => false, 'message' => 'Task cannot be started from its current status.'], 422);
        }

        $assignment->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task started successfully.',
            'data' => $assignment->fresh(),
        ]);
    }

    public function completeTask(Request $request, Penugasan $assignment)
    {
        if ($assignment->anggota_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'You can only complete your own task.'], 403);
        }

        $validated = $request->validate([
            'catatan_penyelesaian' => ['nullable', 'string'],
            'bukti_selesai' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ]);

        if ($request->hasFile('bukti_selesai')) {
            $path = $request->file('bukti_selesai')->store('proofs');
            $validated['bukti_selesai'] = $path;
        }

        $assignment->fill($validated);
        $assignment->status = 'waiting_verification';
        $assignment->completed_at = now();
        $assignment->save();

        return response()->json([
            'success' => true,
            'message' => 'Task completion submitted for verification.',
            'data' => $assignment->fresh(),
        ]);
    }

    public function verify(Request $request, Penugasan $assignment)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['completed', 'in_progress'])],
            'catatan_verifikasi' => ['nullable', 'string'],
        ]);

        if ($request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Only administrators can verify tasks.'], 403);
        }

        if ($assignment->anggota_id === $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'A member cannot verify their own task.'], 403);
        }

        $assignment->status = $validated['status'];
        $assignment->verified_by = $request->user()->id;
        $assignment->verified_at = now();
        $assignment->catatan_verifikasi = $validated['catatan_verifikasi'] ?? null;
        if ($validated['status'] === 'completed') {
            $assignment->completed_at = $assignment->completed_at ?? now();
        }
        $assignment->save();

        return response()->json([
            'success' => true,
            'message' => 'Task verification processed successfully.',
            'data' => $assignment->fresh(),
        ]);
    }
}
