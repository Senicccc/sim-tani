<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\KegiatanPekerjaan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KegiatanPekerjaanController extends Controller
{
    public function store(Request $request, Kegiatan $activity)
    {
        $validated = $request->validate([
            'jenis_pekerjaan_id' => ['required', 'exists:jenis_pekerjaan,id'],
            'jumlah_orang_dibutuhkan' => ['required', 'integer', 'min:1'],
            'jumlah_satuan' => ['nullable', 'numeric', 'min:0'],
            'tarif_per_satuan' => ['nullable', 'numeric', 'min:0'],
            'tingkat_kemampuan_minimal' => ['nullable', Rule::in(['pemula', 'menengah', 'mahir'])],
            'catatan' => ['nullable', 'string'],
        ]);

        $validated['kegiatan_id'] = $activity->id;

        $requirement = KegiatanPekerjaan::firstOrCreate([
            'kegiatan_id' => $activity->id,
            'jenis_pekerjaan_id' => $validated['jenis_pekerjaan_id'],
        ], $validated);

        return response()->json([
            'success' => true,
            'message' => 'Activity job requirement saved successfully.',
            'data' => $requirement->load('jobType'),
        ], 201);
    }
}
