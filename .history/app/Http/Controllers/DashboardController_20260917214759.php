<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Penugasan;
use App\Models\PermintaanPerubahan;
use App\Models\Upah;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role === 'admin') {
            return response()->json([
                'success' => true,
                'message' => 'Admin dashboard retrieved successfully.',
                'data' => [
                    'total_active_members' => User::where('role', 'anggota')->where('status_aktif', true)->count(),
                    'total_activities' => Kegiatan::count(),
                    'ongoing_activities' => Kegiatan::where('status', 'ongoing')->count(),
                    'pending_change_requests' => PermintaanPerubahan::where('status', 'pending')->count(),
                    'unpaid_wages' => Upah::where('status_pembayaran', 'belum_dibayar')->sum('jumlah_upah'),
                    'completed_tasks' => Penugasan::where('status', 'completed')->count(),
                ],
            ]);
        }

        $memberId = $request->user()->id;

        return response()->json([
            'success' => true,
            'message' => 'Member dashboard retrieved successfully.',
            'data' => [
                'my_current_assignments' => Penugasan::where('anggota_id', $memberId)->whereIn('status', ['assigned', 'in_progress', 'waiting_verification'])->count(),
                'my_completed_task_count' => Penugasan::where('anggota_id', $memberId)->where('status', 'completed')->count(),
                'my_pending_requests' => PermintaanPerubahan::where('diajukan_oleh', $memberId)->where('status', 'pending')->count(),
                'my_unpaid_wage_total' => Upah::whereHas('assignment', fn ($query) => $query->where('anggota_id', $memberId))->where('status_pembayaran', 'belum_dibayar')->sum('jumlah_upah'),
                'upcoming_activities' => Kegiatan::whereDate('tanggal_mulai', '>=', now()->toDateString())->limit(5)->get(),
            ],
        ]);
    }
}
