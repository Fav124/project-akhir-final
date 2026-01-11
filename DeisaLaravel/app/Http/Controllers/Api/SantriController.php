<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\WaliSantri;
use Illuminate\Support\Facades\DB;

class SantriController extends Controller
{
    public function index()
    {
        return response()->json(Santri::with(['kelas', 'jurusan', 'wali'])->paginate(15));
    }

    public function show($id)
    {
        return response()->json(Santri::with(['kelas', 'jurusan', 'wali', 'sakit'])->findOrFail($id));
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
        // Similar update logic...
        $santri->update($request->all());
        return response()->json($santri);
    }

    public function destroy($id)
    {
        Santri::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
