<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PresensiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Attendance retrieved successfully.',
            'data' => Presensi::with('assignment.member')->latest()->get(),
        ]);
    }

    public function myAttendance(Request $request)
    {
        $attendance = Presensi::query()
            ->whereHas('assignment', function ($query) use ($request) {
                $query->where('anggota_id', $request->user()->id);
            })
            ->with('assignment.member')
            ->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Your attendance records retrieved successfully.',
            'data' => $attendance,
        ]);
    }

    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'penugasan_id' => ['required', 'exists:penugasan,id'],
            'catatan' => ['nullable', 'string'],
        ]);

        $assignment = Penugasan::findOrFail($validated['penugasan_id']);
        if ($assignment->anggota_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'You can only manage your own attendance.'], 403);
        }

        if ($assignment->status === 'cancelled') {
            return response()->json(['success' => false, 'message' => 'Cancelled assignments cannot have attendance.'], 422);
        }

        $existing = Presensi::where('penugasan_id', $assignment->id)->first();
        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Attendance for this assignment already exists.'], 409);
        }

        $attendance = Presensi::create([
            'penugasan_id' => $assignment->id,
            'waktu_check_in' => now(),
            'status' => 'hadir',
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in recorded successfully.',
            'data' => $attendance,
        ], 201);
    }

    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'penugasan_id' => ['required', 'exists:penugasan,id'],
            'catatan' => ['nullable', 'string'],
        ]);

        $attendance = Presensi::where('penugasan_id', $validated['penugasan_id'])->firstOrFail();
        $assignment = $attendance->assignment;

        if ($assignment->anggota_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'You can only manage your own attendance.'], 403);
        }

        if ($attendance->waktu_check_in === null) {
            return response()->json(['success' => false, 'message' => 'Cannot check out before checking in.'], 422);
        }

        $checkOutTime = now();
        if ($checkOutTime->lt($attendance->waktu_check_in)) {
            return response()->json(['success' => false, 'message' => 'Check-out cannot be earlier than check-in.'], 422);
        }

        $attendance->update([
            'waktu_check_out' => $checkOutTime,
            'catatan' => $validated['catatan'] ?? $attendance->catatan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out recorded successfully.',
            'data' => $attendance->fresh(),
        ]);
    }
}
