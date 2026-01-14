<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::paginate(15);
        return view('jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required',
            'kode_jurusan' => 'required|unique:jurusans',
        ]);

        Jurusan::create($request->all());

        return redirect()->route('web.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required',
            'kode_jurusan' => 'required|unique:jurusans,kode_jurusan,' . $jurusan->id,
        ]);

        $jurusan->update($request->all());

        return redirect()->route('web.jurusan.index')->with('success', 'Data jurusan diperbarui.');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return redirect()->route('web.jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
