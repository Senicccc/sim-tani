<?php

namespace App\Http\Controllers;

use App\Models\JenisPekerjaan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JenisPekerjaanController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Jabatan / job types retrieved successfully.',
            'data' => JenisPekerjaan::with('creator')->latest()->get(),
        ]);
    }

    public function show(JenisPekerjaan $jobType)
    {
        return response()->json([
            'success' => true,
            'message' => 'Job type retrieved successfully.',
            'data' => $jobType->load('creator'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pekerjaan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'satuan' => ['required', 'string', 'max:50'],
            'tarif_default' => ['nullable', 'numeric', 'min:0'],
            'status_aktif' => ['sometimes', 'boolean'],
        ]);

        $validated['created_by'] = $request->user()->id;
        $validated['status_aktif'] = $validated['status_aktif'] ?? true;

        $jobType = JenisPekerjaan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Job type created successfully.',
            'data' => $jobType,
        ], 201);
    }

    public function update(Request $request, JenisPekerjaan $jobType)
    {
        $validated = $request->validate([
            'nama_pekerjaan' => ['sometimes', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'satuan' => ['sometimes', 'string', 'max:50'],
            'tarif_default' => ['nullable', 'numeric', 'min:0'],
            'status_aktif' => ['sometimes', 'boolean'],
        ]);

        $jobType->fill($validated);
        $jobType->save();

        return response()->json([
            'success' => true,
            'message' => 'Job type updated successfully.',
            'data' => $jobType->fresh(),
        ]);
    }

    public function destroy(JenisPekerjaan $jobType)
    {
        $jobType->update(['status_aktif' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Job type deactivated successfully.',
            'data' => null,
        ]);
    }
}
