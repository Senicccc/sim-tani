<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Services\AutoScheduleService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KegiatanController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Activities retrieved successfully.',
            'data' => Kegiatan::with(['creator', 'jobRequirements.jobType'])->latest()->get(),
        ]);
    }

    public function show(Kegiatan $activity)
    {
        return response()->json([
            'success' => true,
            'message' => 'Activity retrieved successfully.',
            'data' => $activity->load(['creator', 'jobRequirements.jobType']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'status' => ['required', Rule::in(['draft', 'scheduled', 'ongoing', 'completed', 'cancelled'])],
            'metode_penjadwalan' => ['required', Rule::in(['otomatis', 'manual'])],
        ]);

        $validated['created_by'] = $request->user()->id;
        $activity = Kegiatan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Activity created successfully.',
            'data' => $activity,
        ], 201);
    }

    public function update(Request $request, Kegiatan $activity)
    {
        $validated = $request->validate([
            'nama_kegiatan' => ['sometimes', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'tanggal_mulai' => ['sometimes', 'date'],
            'tanggal_selesai' => ['sometimes', 'date', 'after_or_equal:tanggal_mulai'],
            'status' => ['sometimes', Rule::in(['draft', 'scheduled', 'ongoing', 'completed', 'cancelled'])],
            'metode_penjadwalan' => ['sometimes', Rule::in(['otomatis', 'manual'])],
        ]);

        $activity->fill($validated);
        $activity->save();

        return response()->json([
            'success' => true,
            'message' => 'Activity updated successfully.',
            'data' => $activity->fresh(),
        ]);
    }

    public function destroy(Kegiatan $activity)
    {
        $activity->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Activity cancelled successfully.',
            'data' => null,
        ]);
    }

    public function generateSchedule(Kegiatan $activity, AutoScheduleService $scheduleService)
    {
        $result = $scheduleService->generateForActivity($activity);

        return response()->json([
            'success' => $result['number_assigned'] > 0 || empty($result['warnings']),
            'message' => $result['warnings'] ? 'Schedule generated with warnings.' : 'Schedule generated successfully.',
            'data' => $result,
        ]);
    }
}
