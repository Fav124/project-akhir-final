<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AngkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        \App\Models\Angkatan::syncNames();
        $angkatans = \App\Models\Angkatan::withCount(['santris'])->orderBy('tahun', 'desc')->get();
        return view('admin.angkatan.index', compact('angkatans'));
    }

    public function create()
    {
        if (request()->ajax()) {
            return view('admin.angkatan._form_modal');
        }
        return view('admin.angkatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100|unique:angkatans,tahun',
            'nama_angkatan' => 'nullable|string|max:255',
        ]);

        try {
            $angkatan = \App\Models\Angkatan::create([
                'tahun' => $request->tahun,
                'nama_angkatan' => $request->nama_angkatan ?? "Angkatan ({$request->tahun})",
            ]);

            \App\Models\Angkatan::syncNames();

            \App\Models\ActivityLog::create([
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'action' => 'CREATE',
                'module' => 'Angkatan',
                'detail' => "Menambahkan angkatan baru: {$angkatan->tahun}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Angkatan berhasil ditambahkan', 'reload' => true]);
            }
            return redirect()->route('admin.angkatan.index')->with('success', 'Angkatan berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menambahkan angkatan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menambahkan angkatan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $angkatan = \App\Models\Angkatan::findOrFail($id);
        if (request()->ajax()) {
            return view('admin.angkatan._form_modal', compact('angkatan'));
        }
        return view('admin.angkatan.edit', compact('angkatan'));
    }

    public function update(Request $request, $id)
    {
        $angkatan = \App\Models\Angkatan::findOrFail($id);
        $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100|unique:angkatans,tahun,' . $id,
            'nama_angkatan' => 'nullable|string|max:255',
        ]);

        try {
            $angkatan->update([
                'tahun' => $request->tahun,
                'nama_angkatan' => $request->nama_angkatan,
            ]);

            \App\Models\Angkatan::syncNames();

            \App\Models\ActivityLog::create([
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'action' => 'UPDATE',
                'module' => 'Angkatan',
                'detail' => "Memperbarui data angkatan: {$angkatan->tahun}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Data angkatan berhasil diperbarui', 'reload' => true]);
            }
            return redirect()->route('admin.angkatan.index')->with('success', 'Data angkatan berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal update angkatan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal update angkatan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $angkatan = \App\Models\Angkatan::findOrFail($id);
            $tahun = $angkatan->tahun;

            // Validation: Cannot delete if has students
            if ($angkatan->santris()->count() > 0) {
                throw new \Exception("Tidak dapat menghapus angkatan yang masih memiliki santri.");
            }

            $angkatan->delete();

            \App\Models\ActivityLog::create([
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'action' => 'DELETE',
                'module' => 'Angkatan',
                'detail' => "Menghapus data angkatan: {$tahun}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Angkatan berhasil dihapus', 'reload' => true]);
            }
            return redirect()->back()->with('success', 'Angkatan berhasil dihapus');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menghapus angkatan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menghapus angkatan: ' . $e->getMessage());
        }
    }
}
