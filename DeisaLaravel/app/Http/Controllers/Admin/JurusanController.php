<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $query = Jurusan::query();

        if ($request->has('search') && $request->search != '') {
            $term = $request->search;
            $query->where('nama_jurusan', 'like', "%{$term}%")
                ->orWhere('kode_jurusan', 'like', "%{$term}%");
        }

        $jurusans = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('admin.jurusan._table', compact('jurusans'));
        }

        return view('admin.jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        if (request()->ajax()) {
            return view('admin.jurusan._form_modal');
        }
        return view('admin.jurusan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:50|unique:jurusans,kode_jurusan',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            $jurusan = Jurusan::create($validated);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'CREATE',
                'module' => 'Jurusan',
                'detail' => "Menambahkan jurusan baru: {$jurusan->nama_jurusan}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Jurusan berhasil ditambahkan', 'reload' => true]);
            }
            return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menambahkan jurusan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menambahkan jurusan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        if (request()->ajax()) {
            return view('admin.jurusan._form_modal', compact('jurusan'));
        }
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:50|unique:jurusans,kode_jurusan,' . $id,
            'deskripsi' => 'nullable|string',
        ]);

        try {
            $jurusan->update($validated);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'UPDATE',
                'module' => 'Jurusan',
                'detail' => "Memperbarui data jurusan: {$jurusan->nama_jurusan}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Data jurusan berhasil diperbarui', 'reload' => true]);
            }
            return redirect()->route('admin.jurusan.index')->with('success', 'Data jurusan berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal update jurusan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal update jurusan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $jurusan = Jurusan::findOrFail($id);

            // Optional: Check if jurusan has kelas
            if ($jurusan->kelas()->exists()) {
                return response()->json(['message' => 'Gagal menghapus! Jurusan ini masih memiliki data kelas.'], 422);
            }

            $jurusanName = $jurusan->nama_jurusan;
            $jurusan->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'DELETE',
                'module' => 'Jurusan',
                'detail' => "Menghapus data jurusan: {$jurusanName}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Jurusan berhasil dihapus', 'reload' => true]);
            }
            return redirect()->back()->with('success', 'Jurusan berhasil dihapus');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menghapus jurusan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menghapus jurusan: ' . $e->getMessage());
        }
    }
}
