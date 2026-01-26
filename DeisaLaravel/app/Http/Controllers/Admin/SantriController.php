<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with(['kelas', 'jurusan', 'angkatan'])->where('status_akademik', 'Aktif');

        if ($request->has('search') && $request->search != '') {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('nama_lengkap', 'like', "%{$term}%")
                    ->orWhere('nis', 'like', "%{$term}%");
            });
        }

        if ($request->has('kelas') && $request->kelas != '') {
            $query->whereHas('kelas', function ($q) use ($request) {
                $q->where('nama_kelas', $request->kelas);
            });
        }

        $santris = $query->latest()->paginate(10);
        $classes = Kelas::all();
        $jurusans = \App\Models\Jurusan::all();
        $angkatans = \App\Models\Angkatan::orderBy('tahun', 'desc')->get();

        if ($request->ajax() && $request->has('search')) {
            return "<div id=\"table-container\">" . view('admin.santri._table', compact('santris'))->render() . "</div>";
        }

        if ($request->ajax()) {
            return view('admin.santri._table', compact('santris'));
        }

        return view('admin.santri.index', compact('santris', 'classes', 'jurusans', 'angkatans'));
    }

    public function show($id)
    {
        $santri = Santri::with(['kelas', 'jurusan', 'wali'])->findOrFail($id);
        if (request()->ajax()) {
            return view('admin.santri._detail', compact('santri'));
        }
        return view('admin.santri.show', compact('santri'));
    }

    public function create()
    {
        $classes = Kelas::with('jurusans')->get();
        $jurusans = \App\Models\Jurusan::all();
        $angkatans = \App\Models\Angkatan::orderBy('tahun', 'desc')->get();
        if (request()->ajax()) {
            return view('admin.santri._form_modal', compact('classes', 'jurusans', 'angkatans'));
        }
        return view('admin.santri.create', compact('classes', 'jurusans', 'angkatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:santris,nis',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'status_kesehatan' => 'required|in:Sehat,Sakit,Rawat Inap,Pulang',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'tahun_masuk' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'alamat' => 'nullable|string|max:500',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'riwayat_alergi' => 'nullable|string',
            // Wali fields
            'nama_wali' => 'nullable|string|max:255',
            'hubungan' => 'nullable|required_with:nama_wali|string|max:100',
            'no_hp' => 'nullable|required_with:nama_wali|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        try {
            \DB::beginTransaction();
            $santri = Santri::create($validated);

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('santri-photos', 'public');
                $santri->foto = $path;
                $santri->save();
            }

            if ($request->filled('nama_wali')) {
                $santri->wali()->create([
                    'nama_wali' => $request->nama_wali,
                    'hubungan' => $request->hubungan,
                    'no_hp' => $request->no_hp,
                    'pekerjaan' => $request->pekerjaan,
                ]);
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'CREATE',
                'module' => 'Santri',
                'detail' => "Menambahkan data santri baru: {$santri->nama_lengkap}",
                'ip_address' => $request->ip()
            ]);

            \DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Santri berhasil ditambahkan', 'reload' => true]);
            }
            return redirect()->route('admin.santri.index')->with('success', 'Santri berhasil ditambahkan');
        } catch (\Exception $e) {
            \DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menambahkan santri: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menambahkan santri: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $santri = Santri::with(['kelas', 'jurusan', 'wali', 'angkatan'])->findOrFail($id);
        $classes = Kelas::with('jurusans')->get();
        $jurusans = \App\Models\Jurusan::all();
        $angkatans = \App\Models\Angkatan::orderBy('tahun', 'desc')->get();
        if (request()->ajax()) {
            return view('admin.santri._form_modal', compact('santri', 'classes', 'jurusans', 'angkatans'));
        }
        return view('admin.santri.edit', compact('santri', 'classes', 'jurusans', 'angkatans'));
    }

    public function update(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);
        $validated = $request->validate([
            'nis' => 'required|unique:santris,nis,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'status_kesehatan' => 'required|in:Sehat,Sakit,Rawat Inap,Pulang',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'tahun_masuk' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'alamat' => 'nullable|string|max:500',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'riwayat_alergi' => 'nullable|string',
            // Wali fields
            'nama_wali' => 'nullable|string|max:255',
            'hubungan' => 'nullable|required_with:nama_wali|string|max:100',
            'no_hp' => 'nullable|required_with:nama_wali|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        try {
            \DB::beginTransaction();
            $santri->update($validated);

            if ($request->hasFile('foto')) {
                // Delete old photo if exists
                if ($santri->foto && \Storage::disk('public')->exists($santri->foto)) {
                    \Storage::disk('public')->delete($santri->foto);
                }
                $path = $request->file('foto')->store('santri-photos', 'public');
                $santri->foto = $path;
                $santri->save();
            }

            if ($request->filled('nama_wali')) {
                $santri->wali()->updateOrCreate(
                    ['santri_id' => $santri->id],
                    [
                        'nama_wali' => $request->nama_wali,
                        'hubungan' => $request->hubungan,
                        'no_hp' => $request->no_hp,
                        'pekerjaan' => $request->pekerjaan,
                    ]
                );
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'UPDATE',
                'module' => 'Santri',
                'detail' => "Memperbarui data santri: {$santri->nama_lengkap}",
                'ip_address' => $request->ip()
            ]);

            \DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Data santri berhasil diperbarui', 'reload' => true]);
            }
            return redirect()->route('admin.santri.index')->with('success', 'Data santri berhasil diperbarui');
        } catch (\Exception $e) {
            \DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal update santri: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal update santri: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $santri = Santri::findOrFail($id);
            $santriName = $santri->nama_lengkap;
            $santri->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'DELETE',
                'module' => 'Santri',
                'detail' => "Menghapus data santri: {$santriName}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Santri berhasil dihapus', 'reload' => true]);
            }
            return redirect()->back()->with('success', 'Santri berhasil dihapus');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menghapus santri: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menghapus santri: ' . $e->getMessage());
        }
    }
}
