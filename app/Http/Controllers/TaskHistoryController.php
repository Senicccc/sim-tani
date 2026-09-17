<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use Illuminate\Http\Request;

class TaskHistoryController extends Controller
{
    public function myHistory(Request $request)
    {
        $history = Penugasan::query()
            ->with(['activityJobRequirement.jobType', 'activityJobRequirement.activity'])
            ->where('anggota_id', $request->user()->id)
            ->where('status', 'completed')
            ->latest('completed_at')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Task history retrieved successfully.',
            'data' => $history,
        ]);
    }
}
