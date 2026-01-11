<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\WaliSantri;
use Illuminate\Support\Facades\DB;

class SantriController extends Controller
{
    public function index()
    {
        $santris = Santri::with(['kelas', 'jurusan'])->paginate(15);
        return view('santri.index', compact('santris'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $jurusans = Jurusan::all();
        return view('santri.create', compact('kelas', 'jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:santris',
            'nama_lengkap' => 'required',
            'nama' => 'nullable|string',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_wali' => 'nullable|string',
            'no_telp_wali' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
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

            WaliSantri::create([
                'santri_id' => $santri->id,
                'nama_wali' => $request->nama_wali ?? 'Belum Diisi',
                'hubungan' => $request->hubungan_wali ?? 'Wali',
                'no_hp' => $request->no_telp_wali ?? '',
                'no_telp_wali' => $request->no_telp_wali ?? '',
                'pekerjaan' => $request->pekerjaan_wali,
                'alamat' => $request->alamat_wali ?? $santri->alamat,
            ]);
        });

        return redirect()->route('santri.index')->with('success', 'Santri berhasil ditambahkan.');
    }

    public function edit(Santri $santri)
    {
        $santri->load('wali');
        $kelas = Kelas::all();
        $jurusans = Jurusan::all();
        return view('santri.edit', compact('santri', 'kelas', 'jurusans'));
    }

    public function update(Request $request, Santri $santri)
    {
        $request->validate([
            'nis' => 'required|unique:santris,nis,' . $santri->id,
            'nama_lengkap' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        DB::transaction(function () use ($request, $santri) {
            $santri->update($request->only([
                'nis', 'nama_lengkap', 'nama', 'kelas_id', 'jurusan_id', 'jenis_kelamin',
                'tempat_lahir', 'tanggal_lahir', 'alamat', 'golongan_darah', 'riwayat_alergi'
            ]));

            $santri->wali()->updateOrCreate(
                ['santri_id' => $santri->id],
                [
                    'nama_wali' => $request->nama_wali,
                    'no_hp' => $request->no_telp_wali,
                    'no_telp_wali' => $request->no_telp_wali,
                    'hubungan' => $request->hubungan_wali,
                    'pekerjaan' => $request->pekerjaan_wali,
                    'alamat' => $request->alamat_wali ?? $santri->alamat,
                ]
            );
        });

        return redirect()->route('santri.index')->with('success', 'Data santri diperbarui.');
    }

    public function destroy(Santri $santri)
    {
        $santri->delete();
        return redirect()->route('santri.index')->with('success', 'Santri berhasil dihapus.');
    }
}
