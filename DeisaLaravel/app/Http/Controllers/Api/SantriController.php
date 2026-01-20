<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\WaliSantri;
use Illuminate\Support\Facades\DB;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Santri::with(['kelas', 'jurusan', 'wali']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                    ->orWhere('nis', 'LIKE', "%{$search}%");
            });
        }

        $paginated = $query->paginate(15);
        return response()->json([
            'success' => true,
            'data' => $paginated->items(),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ]
        ]);
    }

    public function show($id)
    {
        $santri = Santri::with(['kelas', 'jurusan', 'wali', 'sakit'])->findOrFail($id);

        $stats = [
            'total_sick_records' => $santri->sakit->count(),
            'currently_sick' => $santri->status_kesehatan !== 'Sehat'
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'santri' => $santri,
                'statistics' => $stats,
                'recent_sick_records' => $santri->sakit->take(5)
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:santris',
            'nama_lengkap' => 'required',
            'nama' => 'nullable|string', // Fallback
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_wali' => 'nullable|string',
            'no_hp_wali' => 'nullable|string',
            'no_telp_wali' => 'nullable|string', // Renamed in Android
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $santri = Santri::create([
                    'nis' => $request->nis,
                    'nama_lengkap' => $request->nama_lengkap,
                    'nama' => $request->nama ?? explode(' ', $request->nama_lengkap)[0],
                    'kelas_id' => $request->kelas_id,
                    'jurusan_id' => $request->jurusan_id,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'tahun_masuk' => $request->tahun_masuk ?? date('Y'),
                    'alamat' => $request->alamat,
                    'golongan_darah' => $request->golongan_darah,
                    'riwayat_alergi' => $request->riwayat_alergi,
                    'status_kesehatan' => 'Sehat'
                ]);

                // Handle WaliSantri
                WaliSantri::create([
                    'santri_id' => $santri->id,
                    'nama_wali' => $request->nama_wali ?? 'Belum Diisi',
                    'hubungan' => $request->hubungan_wali ?? 'Wali',
                    'no_hp' => $request->no_telp_wali ?? $request->no_hp_wali ?? '',
                    'no_telp_wali' => $request->no_telp_wali ?? $request->no_hp_wali ?? '',
                    'pekerjaan' => $request->pekerjaan_wali,
                    'alamat' => $request->alamat_wali ?? $request->alamat
                ]);

                return response()->json([
                    'success' => true,
                    'data' => $santri->load('wali')
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);
        
        try {
            return DB::transaction(function () use ($request, $santri) {
                $santri->update([
                    'nis' => $request->nis ?? $santri->nis,
                    'nama_lengkap' => $request->nama_lengkap ?? $santri->nama_lengkap,
                    'nama' => $request->nama ?? explode(' ', $request->nama_lengkap ?? $santri->nama_lengkap)[0],
                    'kelas_id' => $request->kelas_id ?? $santri->kelas_id,
                    'jurusan_id' => $request->jurusan_id ?? $santri->jurusan_id,
                    'jenis_kelamin' => $request->jenis_kelamin ?? $santri->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir ?? $santri->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir ?? $santri->tanggal_lahir,
                    'tahun_masuk' => $request->tahun_masuk ?? $santri->tahun_masuk,
                    'alamat' => $request->alamat ?? $santri->alamat,
                    'golongan_darah' => $request->golongan_darah ?? $santri->golongan_darah,
                    'riwayat_alergi' => $request->riwayat_alergi ?? $santri->riwayat_alergi,
                    'status_kesehatan' => $request->status_kesehatan ?? $santri->status_kesehatan
                ]);

                // Update WaliSantri if exists
                if ($santri->wali) {
                    $santri->wali->update([
                        'nama_wali' => $request->nama_wali ?? $santri->wali->nama_wali,
                        'hubungan' => $request->hubungan_wali ?? $santri->wali->hubungan,
                        'no_hp' => $request->no_telp_wali ?? $request->no_hp_wali ?? $santri->wali->no_hp,
                        'pekerjaan' => $request->pekerjaan_wali ?? $santri->wali->pekerjaan,
                        'alamat' => $request->alamat_wali ?? $santri->wali->alamat
                    ]);
                } elseif ($request->nama_wali) {
                    WaliSantri::create([
                        'santri_id' => $santri->id,
                        'nama_wali' => $request->nama_wali ?? 'Belum Diisi',
                        'hubungan' => $request->hubungan_wali ?? 'Wali',
                        'no_hp' => $request->no_telp_wali ?? $request->no_hp_wali ?? '',
                        'pekerjaan' => $request->pekerjaan_wali,
                        'alamat' => $request->alamat_wali ?? $request->alamat
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Data santri berhasil diperbarui',
                    'data' => $santri->load(['kelas', 'jurusan', 'wali'])
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        Santri::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
