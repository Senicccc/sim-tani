<?php

namespace App\Http\Controllers;

use App\Models\AnggotaJenisPekerjaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnggotaJenisPekerjaanController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Competencies retrieved successfully.',
            'data' => AnggotaJenisPekerjaan::with(['user', 'jobType'])->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => ['required', 'exists:users,id'],
            'jenis_pekerjaan_id' => ['required', 'exists:jenis_pekerjaan,id'],
            'tingkat_kemampuan' => ['required', Rule::in(['pemula', 'menengah', 'mahir'])],
        ]);

        $member = User::findOrFail($validated['anggota_id']);
        if ($member->role !== 'anggota') {
            return response()->json(['success' => false, 'message' => 'Only member users may have job competencies.'], 422);
        }

        $competency = AnggotaJenisPekerjaan::updateOrCreate(
            [
                'anggota_id' => $validated['anggota_id'],
                'jenis_pekerjaan_id' => $validated['jenis_pekerjaan_id'],
            ],
            ['tingkat_kemampuan' => $validated['tingkat_kemampuan']]
        );

        return response()->json([
            'success' => true,
            'message' => 'Member competency saved successfully.',
            'data' => $competency->load(['user', 'jobType']),
        ], 201);
    }

    public function update(Request $request, AnggotaJenisPekerjaan $competency)
    {
        $validated = $request->validate([
            'tingkat_kemampuan' => ['required', Rule::in(['pemula', 'menengah', 'mahir'])],
        ]);

        $competency->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Member competency updated successfully.',
            'data' => $competency->fresh()->load(['user', 'jobType']),
        ]);
    }

    public function destroy(AnggotaJenisPekerjaan $competency)
    {
        $competency->delete();

        return response()->json([
            'success' => true,
            'message' => 'Competency deleted successfully.',
            'data' => null,
        ]);
    }
}
