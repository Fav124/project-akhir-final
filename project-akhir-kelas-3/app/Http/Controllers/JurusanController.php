<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of jurusan
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Jurusan::withCount(['kelas', 'santris']);

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where('nama', 'LIKE', "%{$search}%")
                      ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            }

            $jurusans = $query->orderBy('nama')->paginate(10);
            return view('jurusan.table', compact('jurusans'))->render();
        }

        $jurusans = Jurusan::withCount(['kelas', 'santris'])->orderBy('nama')->paginate(10);
        return view('jurusan.index', compact('jurusans'));
    }

    /**
     * Show the form for creating a new jurusan
     */
    public function create()
    {
        return view('jurusan.create');
    }

    /**
     * Store a newly created jurusan
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:jurusans,nama',
            'deskripsi' => 'nullable|string'
        ]);

        Jurusan::create($request->only(['nama', 'deskripsi']));

        return redirect()->route('jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan! 🎉');
    }

    /**
     * Show the form for editing the specified jurusan
     */
    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    /**
     * Update the specified jurusan
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:jurusans,nama,' . $jurusan->id,
            'deskripsi' => 'nullable|string'
        ]);

        $jurusan->update($request->only(['nama', 'deskripsi']));

        return redirect()->route('jurusan.index')
            ->with('success', 'Jurusan berhasil diperbarui! ✏️');
    }

    /**
     * Remove the specified jurusan
     */
    public function destroy(Jurusan $jurusan)
    {
        // Check if jurusan has kelas or santri
        if ($jurusan->kelas()->count() > 0) {
            return redirect()->route('jurusan.index')
                ->with('error', 'Tidak dapat menghapus jurusan yang masih memiliki kelas!');
        }

        if ($jurusan->santris()->count() > 0) {
            return redirect()->route('jurusan.index')
                ->with('error', 'Tidak dapat menghapus jurusan yang masih memiliki santri!');
        }

        $jurusan->delete();

        return redirect()->route('jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus!');
    }
}
