<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::with(['jurusans']);

        if ($request->has('search') && $request->search != '') {
            $term = $request->search;
            $query->where('nama_kelas', 'like', "%{$term}%")
                ->orWhereHas('jurusans', function ($q) use ($term) {
                $q->where('nama_jurusan', 'like', "%{$term}%");
            });
        }

        $kelases = $query->latest()->paginate(10);
        $jurusans = Jurusan::all();

        if ($request->ajax()) {
            return view('admin.kelas._table', compact('kelases'));
        }

        return view('admin.kelas.index', compact('kelases', 'jurusans'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        if (request()->ajax()) {
            return view('admin.kelas._form_modal', compact('jurusans'));
        }
        return view('admin.kelas.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'nullable|string|max:255',
            'jenjang' => 'required|string|in:TK,SD,SMP,SMA,SMK,Kuliah',
            'tingkat' => 'required|integer|min:1',
            'jurusan_ids' => 'required|array',
            'jurusan_ids.*' => 'exists:jurusans,id',
            'tahun_ajaran' => 'nullable|string|max:50',
        ]);

        try {
            $kelas = Kelas::create([
                'nama_kelas' => $request->nama_kelas,
                'jenjang' => $request->jenjang,
                'tingkat' => $request->tingkat,
                'tahun_ajaran' => $request->tahun_ajaran,
            ]);

            $kelas->jurusans()->attach($request->jurusan_ids);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'CREATE',
                'module' => 'Kelas',
                'detail' => "Menambahkan kelas baru: {$kelas->nama_kelas}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Kelas berhasil ditambahkan', 'reload' => true]);
            }
            return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
        }
        catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menambahkan kelas: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menambahkan kelas: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $kelas = Kelas::with('jurusans')->findOrFail($id);
        $jurusans = Jurusan::all();
        if (request()->ajax()) {
            return view('admin.kelas._form_modal', compact('kelas', 'jurusans'));
        }
        return view('admin.kelas.edit', compact('kelas', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $validated = $request->validate([
            'nama_kelas' => 'nullable|string|max:255',
            'jenjang' => 'required|string|in:TK,SD,SMP,SMA,SMK,Kuliah',
            'tingkat' => 'required|integer|min:1',
            'jurusan_ids' => 'required|array',
            'jurusan_ids.*' => 'exists:jurusans,id',
            'tahun_ajaran' => 'nullable|string|max:50',
        ]);

        try {
            $kelas->update([
                'nama_kelas' => $request->nama_kelas,
                'jenjang' => $request->jenjang,
                'tingkat' => $request->tingkat,
                'tahun_ajaran' => $request->tahun_ajaran,
            ]);

            $kelas->jurusans()->sync($request->jurusan_ids);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'UPDATE',
                'module' => 'Kelas',
                'detail' => "Memperbarui data kelas: {$kelas->nama_kelas}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Data kelas berhasil diperbarui', 'reload' => true]);
            }
            return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil diperbarui');
        }
        catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal update kelas: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal update kelas: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $kelas = Kelas::findOrFail($id);
            $kelasName = $kelas->nama_kelas;
            $kelas->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'DELETE',
                'module' => 'Kelas',
                'detail' => "Menghapus data kelas: {$kelasName}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Kelas berhasil dihapus', 'reload' => true]);
            }
            return redirect()->back()->with('success', 'Kelas berhasil dihapus');
        }
        catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menghapus kelas: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menghapus kelas: ' . $e->getMessage());
        }
    }
}