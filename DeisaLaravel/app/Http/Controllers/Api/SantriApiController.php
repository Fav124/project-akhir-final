<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Activity;
use Illuminate\Http\Request;

class SantriApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with(['kelas', 'jurusan', 'wali', 'sakit']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->has('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->has('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        $santri = $query->orderBy('nama_lengkap')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data santri berhasil diambil',
            'data' => $santri->map(fn (Santri $item) => $this->transformSantri($item))->values(),
        ]);
    }

    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin only.'
            ], 403);
        }

        $validated = $request->validate([
            'nis' => 'required|string|unique:santris,nis',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        $santri = Santri::create($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'create_santri',
            'description' => "Menambah santri: {$santri->nama_lengkap}"
        ]);

        $santri->load(['kelas', 'jurusan', 'wali', 'sakit']);

        return response()->json([
            'success' => true,
            'message' => 'Santri berhasil ditambahkan',
            'data' => $this->transformSantri($santri)
        ], 201);
    }

    public function show($id)
    {
        $santri = Santri::with(['kelas', 'jurusan', 'wali', 'sakit'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail santri berhasil diambil',
            'data' => $this->transformSantri($santri),
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin only.'
            ], 403);
        }

        $santri = Santri::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|string|unique:santris,nis,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        $santri->update($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'update_santri',
            'description' => "Mengupdate santri: {$santri->nama_lengkap}"
        ]);

        $santri->load(['kelas', 'jurusan', 'wali', 'sakit']);

        return response()->json([
            'success' => true,
            'message' => 'Santri berhasil diupdate',
            'data' => $this->transformSantri($santri)
        ]);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin only.'
            ], 403);
        }

        $santri = Santri::findOrFail($id);
        $namaLengkap = $santri->nama_lengkap;
        $santri->delete();

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'delete_santri',
            'description' => "Menghapus santri: {$namaLengkap}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Santri berhasil dihapus'
        ]);
    }

    private function transformSantri(Santri $santri): array
    {
        $latestSakit = $santri->sakit->sortByDesc('created_at')->first();
        $riwayatSakit = $latestSakit?->diagnosis ?? $latestSakit?->diagnosis_utama ?? null;

        return [
            'id' => (int) $santri->id,
            'nama_lengkap' => (string) ($santri->nama_lengkap ?? ''),
            'nis' => (string) ($santri->nis ?? ''),
            'kelas' => [
                'id' => (int) ($santri->kelas?->id ?? 0),
                'nama_kelas' => (string) ($santri->kelas?->nama_kelas ?? ''),
            ],
            'jurusan_list' => $santri->jurusan
                ? [[
                    'id' => (int) $santri->jurusan->id,
                    'nama_jurusan' => (string) ($santri->jurusan->nama_jurusan ?? ''),
                ]]
                : [],
            'tempat_lahir' => (string) ($santri->tempat_lahir ?? ''),
            'tanggal_lahir' => $santri->tanggal_lahir
                ? (string) \Illuminate\Support\Carbon::parse($santri->tanggal_lahir)->toDateString()
                : '',
            'tahun_masuk' => (int) ($santri->tahun_masuk ?? 0),
            'golongan_darah' => (string) ($santri->golongan_darah ?? ''),
            'riwayat_alergi' => $santri->riwayat_alergi,
            'riwayat_sakit' => $riwayatSakit,
            'wali' => $santri->wali ? [
                'id' => (int) $santri->wali->id,
                'nama' => (string) ($santri->wali->nama_wali ?? ''),
                'no_hp' => (string) ($santri->wali->no_hp ?? ''),
                'hubungan' => (string) ($santri->wali->hubungan ?? ''),
            ] : null,
        ];
    }
}
