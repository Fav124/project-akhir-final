<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Santri;
use App\Models\SantriSakit;
use App\Models\Obat;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Admin Dashboard Stats
     */
    public function dashboard()
    {
        try {
            $totalSantri = Santri::count();
            $totalSakit = SantriSakit::where('status', 'Sakit')->count();
            $totalObat = Obat::count();
            $obatHampirHabis = Obat::where('stok', '<', 10)->count();
            $pendingUsers = User::where('status', 'pending')->count();

            // Chart data - last 7 days
            $chartData = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $count = SantriSakit::whereDate('created_at', $date)->count();
                $chartData[] = [
                    'date' => $date->format('Y-m-d'),
                    'label' => $date->format('d M'),
                    'count' => $count
                ];
            }

            // Recent activities
            // Gracefully handle if Activity model/table has issues
            $recentActivities = [];
            try {
                $recentActivities = Activity::with('user')
                    ->latest()
                    ->take(10)
                    ->get()
                    ->map(function ($activity) {
                        return [
                            'id' => $activity->id,
                            'user_name' => $activity->user->name ?? 'System',
                            'action' => $activity->action,
                            'description' => $activity->description,
                            'created_at' => $activity->created_at->diffForHumans()
                        ];
                    });
            } catch (\Exception $e) {
                // Log the error but don't fail the whole dashboard
                \Log::error("Dashboard Activity Error: " . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => [
                        'total_santri' => $totalSantri,
                        'total_sakit' => $totalSakit,
                        'total_obat' => $totalObat,
                        'obat_hampir_habis' => $obatHampirHabis,
                        'pending_users' => $pendingUsers
                    ],
                    'chart_data' => $chartData,
                    'recent_activities' => $recentActivities
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat dashboard: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get pending users
     */
    public function getPendingUsers()
    {
        $users = User::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'created_at' => $user->created_at->format('d M Y H:i')
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Approve user
     */
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);

        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'approve_user',
            'description' => "Menyetujui user: {$user->name}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil disetujui'
        ]);
    }

    /**
     * Reject/Delete user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;
        $user->delete();

        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'delete_user',
            'description' => "Menghapus user: {$userName}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }

    /**
     * Get activity logs
     */
    public function getActivities(Request $request)
    {
        $perPage = $request->get('per_page', 20);

        $activities = Activity::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $activities->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'user_name' => $activity->user->name ?? 'System',
                    'action' => $activity->action,
                    'description' => $activity->description,
                    'created_at' => $activity->created_at->format('d M Y H:i'),
                    'created_at_human' => $activity->created_at->diffForHumans()
                ];
            }),
            'meta' => [
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'per_page' => $activities->perPage(),
                'total' => $activities->total()
            ]
        ]);
    }

    /**
     * Get important notifications
     */
    public function getNotifications()
    {
        $notifications = [];

        // Check for pending users
        $pendingCount = User::where('status', 'pending')->count();
        if ($pendingCount > 0) {
            $notifications[] = [
                'id' => 'pending_users',
                'type' => 'warning',
                'title' => 'Pengguna Menunggu Persetujuan',
                'message' => "{$pendingCount} pengguna menunggu persetujuan Anda",
                'action' => 'user_management',
                'created_at' => now()->toISOString()
            ];
        }

        // Check for critical patient count
        $criticalCount = SantriSakit::where('status', 'Sakit')->count();
        if ($criticalCount >= 5) {
            $notifications[] = [
                'id' => 'critical_patients',
                'type' => 'danger',
                'title' => 'Banyak Santri Sakit',
                'message' => "{$criticalCount} santri sedang dalam perawatan",
                'action' => 'patient_list',
                'created_at' => now()->toISOString()
            ];
        }

        // Check for low stock
        $lowStockCount = Obat::where('stok', '<', 10)->count();
        if ($lowStockCount > 0) {
            $notifications[] = [
                'id' => 'low_stock',
                'type' => 'warning',
                'title' => 'Stok Obat Menipis',
                'message' => "{$lowStockCount} jenis obat stoknya menipis",
                'action' => 'medicine_list',
                'created_at' => now()->toISOString()
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }
}
