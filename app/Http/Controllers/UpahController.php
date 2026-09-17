<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use App\Models\Upah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpahController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Wage records retrieved successfully.',
            'data' => Upah::with(['assignment.member', 'payer'])->latest()->get(),
        ]);
    }

    public function myWages(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Your wage records retrieved successfully.',
            'data' => Upah::with(['assignment.member'])
                ->whereHas('assignment', fn ($query) => $query->where('anggota_id', $request->user()->id))
                ->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'penugasan_id' => ['required', 'exists:penugasan,id', 'unique:upah,penugasan_id'],
            'mode_perhitungan' => ['required', Rule::in(['otomatis', 'manual'])],
            'tarif_per_satuan' => ['nullable', 'numeric', 'min:0'],
            'jumlah_satuan' => ['nullable', 'numeric', 'min:0'],
            'jumlah_upah' => ['nullable', 'numeric', 'min:0'],
            'status_pembayaran' => ['sometimes', Rule::in(['belum_dibayar', 'sudah_dibayar'])],
            'catatan' => ['nullable', 'string'],
        ]);

        $assignment = Penugasan::findOrFail($validated['penugasan_id']);
        if ($validated['mode_perhitungan'] === 'otomatis') {
            $requirement = $assignment->activityJobRequirement;
            $rate = $validated['tarif_per_satuan'] ?? $requirement->tarif_per_satuan ?? $requirement->jobType->tarif_default;
            $quantity = $validated['jumlah_satuan'] ?? $requirement->jumlah_satuan;
            if (! $rate || ! $quantity) {
                return response()->json(['success' => false, 'message' => 'Automatic wage calculation requires a valid rate and quantity.'], 422);
            }
            $validated['jumlah_upah'] = $rate * $quantity;
            $validated['tarif_per_satuan'] = $rate;
            $validated['jumlah_satuan'] = $quantity;
        }

        $validated['status_pembayaran'] = $validated['status_pembayaran'] ?? 'belum_dibayar';

        $wage = Upah::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Wage created successfully.',
            'data' => $wage->load('assignment.member'),
        ], 201);
    }

    public function update(Request $request, Upah $wage)
    {
        $validated = $request->validate([
            'mode_perhitungan' => ['sometimes', Rule::in(['otomatis', 'manual'])],
            'tarif_per_satuan' => ['nullable', 'numeric', 'min:0'],
            'jumlah_satuan' => ['nullable', 'numeric', 'min:0'],
            'jumlah_upah' => ['nullable', 'numeric', 'min:0'],
            'status_pembayaran' => ['sometimes', Rule::in(['belum_dibayar', 'sudah_dibayar'])],
            'catatan' => ['nullable', 'string'],
        ]);

        if ($request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Members cannot modify wages.'], 403);
        }

        $wage->fill($validated);
        $wage->save();

        return response()->json([
            'success' => true,
            'message' => 'Wage updated successfully.',
            'data' => $wage->fresh()->load('assignment.member'),
        ]);
    }

    public function markPaid(Request $request, Upah $wage)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Only admin can mark wages as paid.'], 403);
        }

        $wage->update([
            'status_pembayaran' => 'sudah_dibayar',
            'tanggal_pembayaran' => now(),
            'dibayar_oleh' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Wage marked as paid successfully.',
            'data' => $wage->fresh()->load('assignment.member'),
        ]);
    }
}
