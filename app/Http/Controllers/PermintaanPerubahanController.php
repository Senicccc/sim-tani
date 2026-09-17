<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use App\Models\PermintaanPerubahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PermintaanPerubahanController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Change requests retrieved successfully.',
            'data' => PermintaanPerubahan::with(['assignment.member', 'requester', 'targetAssignment.member', 'targetMember', 'processor'])->latest()->get(),
        ]);
    }

    public function myRequests(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Your change requests retrieved successfully.',
            'data' => PermintaanPerubahan::with(['assignment.member', 'requester', 'targetAssignment.member'])
                ->where('diajukan_oleh', $request->user()->id)
                ->latest()->get(),
        ]);
    }

    public function show(PermintaanPerubahan $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Change request retrieved successfully.',
            'data' => $request->load(['assignment.member', 'requester', 'targetAssignment.member', 'targetMember', 'processor']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'penugasan_id' => ['required', 'exists:penugasan,id'],
            'jenis_permintaan' => ['required', Rule::in(['tukar', 'sanggah'])],
            'target_penugasan_id' => ['nullable', 'exists:penugasan,id'],
            'target_anggota_id' => ['nullable', 'exists:users,id'],
            'alasan' => ['required', 'string'],
        ]);

        $assignment = Penugasan::findOrFail($validated['penugasan_id']);
        if ($assignment->anggota_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Members can only create requests for their own assignment.'], 403);
        }

        $validated['diajukan_oleh'] = $request->user()->id;
        $validated['status'] = 'pending';

        $changeRequest = PermintaanPerubahan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Change request submitted successfully.',
            'data' => $changeRequest->load(['assignment.member', 'requester']),
        ], 201);
    }

    public function process(Request $request, PermintaanPerubahan $changeRequest)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Only admin can process change requests.'], 403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['approved', 'rejected'])],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        if ($changeRequest->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Only pending requests can be processed.'], 422);
        }

        $changeRequest->status = $validated['status'];
        $changeRequest->diproses_oleh = $request->user()->id;
        $changeRequest->diproses_at = now();
        $changeRequest->catatan_admin = $validated['catatan_admin'] ?? null;

        if ($validated['status'] === 'approved' && $changeRequest->jenis_permintaan === 'tukar') {
            $source = $changeRequest->assignment;
            $target = $changeRequest->targetAssignment;

            if (! $source || ! $target) {
                return response()->json(['success' => false, 'message' => 'A valid target assignment is required for swap approval.'], 422);
            }

            DB::transaction(function () use ($source, $target, $changeRequest) {
                $sourceMemberId = $source->anggota_id;
                $targetMemberId = $target->anggota_id;

                $source->anggota_id = $targetMemberId;
                $source->sumber_penugasan = 'hasil_perubahan';
                $target->anggota_id = $sourceMemberId;
                $target->sumber_penugasan = 'hasil_perubahan';

                $source->save();
                $target->save();
            });
        }

        $changeRequest->save();

        return response()->json([
            'success' => true,
            'message' => 'Change request processed successfully.',
            'data' => $changeRequest->fresh()->load(['assignment.member', 'requester', 'targetAssignment.member', 'processor']),
        ]);
    }
}
