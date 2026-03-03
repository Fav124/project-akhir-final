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
        $academicClasses = Kelas::with('jurusans')->orderBy('jenjang')->orderBy('tingkat')->get();
        $selectedClassId = $request->query('kelas_id');
        $currentClass = null;
        $promotionTargets = collect();

        $santris = [];
        if ($selectedClassId) {
            $currentClass = $academicClasses->firstWhere('id', (int) $selectedClassId);
            $santris = Santri::where('kelas_id', $selectedClassId)
                ->where('status_akademik', 'Aktif')
                ->with('jurusan')
                ->get();

            if ($currentClass) {
                $promotionTargets = $academicClasses
                    ->filter(function ($class) use ($currentClass) {
                        return $class->id !== $currentClass->id
                            && $class->jenjang === $currentClass->jenjang
                            && (int) $class->tingkat > (int) $currentClass->tingkat;
                    })
                    ->values();
            }
        }

        return view('admin.akademik.kenaikan_kelas', [
            'academicClasses' => $academicClasses,
            'santris' => $santris,
            'selectedClassId' => $selectedClassId,
            'currentClass' => $currentClass,
            'promotionTargets' => $promotionTargets,
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'santri_ids' => 'required|array',
            'santri_ids.*' => 'exists:santris,id',
            'source_kelas_id' => 'required|exists:kelas,id',
            'action' => 'required|in:promote,graduate,stay',
            'target_kelas_id' => 'required_if:action,promote|exists:kelas,id',
        ]);

        try {
            DB::beginTransaction();

            $santriIds = $request->santri_ids;
            $sourceKelas = Kelas::with('jurusans')->findOrFail($request->source_kelas_id);
            $action = $request->action;
            $count = count($santriIds);
            $selectedSantri = Santri::whereIn('id', $santriIds)->lockForUpdate()->get();

            if ($selectedSantri->count() !== $count) {
                throw new \Exception("Sebagian santri tidak ditemukan.");
            }

            $invalidSource = $selectedSantri->first(function ($santri) use ($sourceKelas) {
                return (int) $santri->kelas_id !== (int) $sourceKelas->id || $santri->status_akademik !== 'Aktif';
            });
            if ($invalidSource) {
                throw new \Exception("Ada santri yang bukan dari kelas sumber atau bukan status aktif.");
            }

            if ($action === 'promote') {
                $targetKelas = Kelas::with('jurusans')->findOrFail($request->target_kelas_id);

                if ((int) $targetKelas->id === (int) $sourceKelas->id) {
                    throw new \Exception("Kelas tujuan tidak boleh sama dengan kelas asal.");
                }

                if ($targetKelas->jenjang !== $sourceKelas->jenjang) {
                    throw new \Exception("Kelas tujuan harus dalam jenjang yang sama ({$sourceKelas->jenjang}).");
                }

                if ((int) $targetKelas->tingkat <= (int) $sourceKelas->tingkat) {
                    throw new \Exception("Kelas tujuan harus memiliki tingkat lebih tinggi dari kelas asal.");
                }

                Santri::whereIn('id', $santriIds)->update([
                    'kelas_id' => $request->target_kelas_id,
                    'status_akademik' => 'Aktif',
                    'is_repeating' => false
                ]);

                $targetJurusanIds = $targetKelas->jurusans->pluck('id')->all();
                $jurusanDisesuaikan = 0;
                if (!empty($targetJurusanIds)) {
                    foreach ($selectedSantri as $santri) {
                        if (!in_array((int) $santri->jurusan_id, $targetJurusanIds, true)) {
                            $santri->update(['jurusan_id' => $targetJurusanIds[0]]);
                            $jurusanDisesuaikan++;
                        }
                    }
                }

                $detail = "Menaikkan {$count} santri dari {$sourceKelas->nama_kelas} ke {$targetKelas->nama_kelas}.";
                if ($jurusanDisesuaikan > 0) {
                    $detail .= " {$jurusanDisesuaikan} santri disesuaikan jurusannya agar valid dengan kelas tujuan.";
                }
            } elseif ($action === 'graduate') {
                Santri::whereIn('id', $santriIds)->update([
                    'status_akademik' => 'Alumni',
                    'kelas_id' => null,
                    'is_repeating' => false
                ]);
                $detail = "Meluluskan {$count} santri dari {$sourceKelas->nama_kelas} menjadi alumni.";
            } elseif ($action === 'stay') {
                // Students staying back are marked as repeating
                Santri::whereIn('id', $santriIds)->update([
                    'status_akademik' => 'Aktif',
                    'is_repeating' => true
                ]);
                $detail = "Menetapkan {$count} santri tetap di {$sourceKelas->nama_kelas} (tinggal kelas).";
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
