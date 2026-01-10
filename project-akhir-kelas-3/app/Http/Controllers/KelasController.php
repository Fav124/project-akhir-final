<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kelas = Kelas::with('jurusans')->get();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('kelas.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100|unique:kelas',
            'jurusans' => 'nullable|array',
            'jurusans.*' => 'exists:jurusans,id'
        ]);

        $kelas = Kelas::create($request->only('nama_kelas'));
        
        if ($request->has('jurusans')) {
            $kelas->jurusans()->sync($request->jurusans);
        }

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit(Kelas $kela)
    {
        $jurusans = Jurusan::all();
        return view('kelas.edit', compact('kela', 'jurusans'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100|unique:kelas,nama_kelas,' . $kela->id,
            'jurusans' => 'nullable|array',
            'jurusans.*' => 'exists:jurusans,id'
        ]);

        $kela->update($request->only('nama_kelas'));
        $kela->jurusans()->sync($request->input('jurusans', []));

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
