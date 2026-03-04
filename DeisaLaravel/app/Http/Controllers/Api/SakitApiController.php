<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SantriSakit;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SakitApiController extends Controller
{
    public function index(Request $request)
    {
        $query = SantriSakit::with(['santri.kelas', 'santri.jurusan', 'santri.wali']);

        if ($request->has('status')) {
            $status = $this->normalizeStatus($request->status);
            $query->where('status', $status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('santri', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        $sakit = $query->orderByDesc('tgl_masuk')->orderByDesc('id')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data santri sakit berhasil diambil',
            'data' => $sakit->map(fn (SantriSakit $item) => $this->transformSakit($item))->values(),
        ]);
    }

    public function store(Request $request)
    {
        $payload = $this->normalizePayload($request);
        $validator = Validator::make($payload, [
            'santri_id' => 'required|exists:santris,id',
            'tgl_masuk' => 'nullable|date',
            'gejala' => 'required|string',
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'jenis_perawatan' => 'required|in:UKS,Rumah Sakit,Pulang',
            'status' => 'required|in:Sakit,Pulang,Sembuh',
            'catatan' => 'nullable|string',
        ]);
        $validated = $validator->validate();

        $sakit = SantriSakit::create($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'create_sakit',
            'description' => "Menambah data sakit: {$sakit->santri->nama_lengkap}"
        ]);

        $sakit->load(['santri.kelas', 'santri.jurusan', 'santri.wali']);

        return response()->json([
            'success' => true,
            'message' => 'Data sakit berhasil ditambahkan',
            'data' => $this->transformSakit($sakit),
        ], 201);
    }

    public function show($id)
    {
        $sakit = SantriSakit::with(['santri.kelas', 'santri.jurusan', 'santri.wali'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail data sakit berhasil diambil',
            'data' => $this->transformSakit($sakit),
        ]);
    }

    public function update(Request $request, $id)
    {
        $sakit = SantriSakit::findOrFail($id);

        $payload = $this->normalizePayload($request);
        $validator = Validator::make($payload, [
            'santri_id' => 'required|exists:santris,id',
            'tgl_masuk' => 'nullable|date',
            'gejala' => 'required|string',
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'jenis_perawatan' => 'required|in:UKS,Rumah Sakit,Pulang',
            'status' => 'required|in:Sakit,Pulang,Sembuh',
            'catatan' => 'nullable|string',
        ]);
        $validated = $validator->validate();

        $sakit->update($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'update_sakit',
            'description' => "Mengupdate data sakit: {$sakit->santri->nama_lengkap}"
        ]);

        $sakit->load(['santri.kelas', 'santri.jurusan', 'santri.wali']);

        return response()->json([
            'success' => true,
            'message' => 'Data sakit berhasil diupdate',
            'data' => $this->transformSakit($sakit),
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

        $sakit = SantriSakit::findOrFail($id);
        $santriNama = $sakit->santri->nama_lengkap;
        $sakit->delete();

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'delete_sakit',
            'description' => "Menghapus data sakit: {$santriNama}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data sakit berhasil dihapus'
        ]);
    }

    private function normalizePayload(Request $request): array
    {
        $tanggalMasuk = $request->input('tanggal_masuk', $request->input('tgl_masuk'));

        return [
            'santri_id' => (int) $request->input('santri_id', $request->input('santriId')),
            'tgl_masuk' => $tanggalMasuk ?: now()->toDateString(),
            'gejala' => (string) $request->input('keluhan_gejala', $request->input('gejala', $request->input('keluhan', ''))),
            'keluhan' => (string) $request->input('keluhan_gejala', $request->input('keluhan', '')),
            'diagnosis' => (string) $request->input('diagnosis', $request->input('diagnosis_utama', '')),
            'diagnosis_utama' => (string) $request->input('diagnosis', $request->input('diagnosis_utama', '')),
            'tindakan' => (string) $request->input('tindakan', ''),
            'jenis_perawatan' => (string) $request->input('lokasi_perawatan', $request->input('jenis_perawatan', 'UKS')),
            'status' => $this->normalizeStatus($request->input('status', 'Sakit')),
            'catatan' => $request->input('pemakaian_obat', $request->input('catatan')),
        ];
    }

    private function normalizeStatus(?string $status): string
    {
        $status = trim((string) $status);
        if ($status === 'Sehat') {
            return 'Sembuh';
        }

        return in_array($status, ['Sakit', 'Pulang', 'Sembuh'], true) ? $status : 'Sakit';
    }

    private function presentStatus(string $status): string
    {
        return $status === 'Sembuh' ? 'Sehat' : $status;
    }

    private function transformSantri(\App\Models\Santri $santri): array
    {
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
                ? (string) Carbon::parse($santri->tanggal_lahir)->toDateString()
                : '',
            'tahun_masuk' => (int) ($santri->tahun_masuk ?? 0),
            'golongan_darah' => (string) ($santri->golongan_darah ?? ''),
            'riwayat_alergi' => $santri->riwayat_alergi,
            'riwayat_sakit' => null,
            'wali' => $santri->wali ? [
                'id' => (int) $santri->wali->id,
                'nama' => (string) ($santri->wali->nama_wali ?? ''),
                'no_hp' => (string) ($santri->wali->no_hp ?? ''),
                'hubungan' => (string) ($santri->wali->hubungan ?? ''),
            ] : null,
        ];
    }

    private function transformSakit(SantriSakit $sakit): array
    {
        return [
            'id' => (int) $sakit->id,
            'santri' => $this->transformSantri($sakit->santri),
            'tanggal_masuk' => $sakit->tgl_masuk
                ? Carbon::parse($sakit->tgl_masuk)->toDateString()
                : now()->toDateString(),
            'keluhan_gejala' => (string) ($sakit->gejala ?? $sakit->keluhan ?? ''),
            'diagnosis' => (string) ($sakit->diagnosis ?? $sakit->diagnosis_utama ?? ''),
            'tindakan' => (string) ($sakit->tindakan ?? ''),
            'pemakaian_obat' => $sakit->catatan,
            'lokasi_perawatan' => (string) ($sakit->jenis_perawatan ?? 'UKS'),
            'status' => $this->presentStatus((string) $sakit->status),
        ];
    }
}
