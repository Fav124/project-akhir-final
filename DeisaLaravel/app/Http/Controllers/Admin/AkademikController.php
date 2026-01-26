<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use DB;

class AkademikController extends Controller
{
    public function index(Request $request)
    {
        $classes = Kelas::with('angkatan')->get();
        $selectedClassId = $request->query('kelas_id');
        
        $santris = [];
        if ($selectedClassId) {
            $santris = Santri::where('kelas_id', $selectedClassId)
                ->where('status_akademik', 'Aktif')
                ->get();
        }

        return view('admin.akademik.kenaikan_kelas', compact('classes', 'santris', 'selectedClassId'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'santri_ids' => 'required|array',
            'action' => 'required|in:promote,graduate,stay',
            'target_kelas_id' => 'required_if:action,promote|exists:kelas,id',
        ]);

        try {
            DB::beginTransaction();
            
            $santriIds = $request->santri_ids;
            $action = $request->action;
            $count = count($santriIds);

            if ($action === 'promote') {
                Santri::whereIn('id', $santriIds)->update([
                    'kelas_id' => $request->target_kelas_id
                ]);
                $detail = "Menaikkan {$count} santri ke kelas baru.";
            } elseif ($action === 'graduate') {
                Santri::whereIn('id', $santriIds)->update([
                    'status_akademik' => 'Alumni',
                    'kelas_id' => null
                ]);
                $detail = "Meluluskan {$count} santri menjadi alumni.";
            } elseif ($action === 'stay') {
                $detail = "Memproses {$count} santri untuk tinggal kelas (data diperbarui).";
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'UPDATE',
                'module' => 'Akademik',
                'detail' => $detail,
                'ip_address' => $request->ip()
            ]);

            DB::commit();
            return response()->json(['message' => 'Proses akademik berhasil diselesaikan!', 'reload' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal memproses: ' . $e->getMessage()], 500);
        }
    }
}
