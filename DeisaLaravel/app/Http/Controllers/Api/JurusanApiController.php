<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Activity;
use Illuminate\Http\Request;

class JurusanApiController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();

        return response()->json([
            'success' => true,
            'data' => $jurusan->map(function ($j) {
                return [
                    'id' => $j->id,
                    'nama_jurusan' => $j->nama_jurusan,
                    'kode' => $j->kode ?? null
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusan',
            'kode' => 'nullable|string|max:10'
        ]);

        $jurusan = Jurusan::create($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'create_jurusan',
            'description' => "Menambah jurusan: {$jurusan->nama_jurusan}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil ditambahkan',
            'data' => $jurusan
        ], 201);
    }

    public function show($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return response()->json(['success' => true, 'data' => $jurusan]);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $jurusan = Jurusan::findOrFail($id);

        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusan,nama_jurusan,' . $id,
            'kode' => 'nullable|string|max:10'
        ]);

        $jurusan->update($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'update_jurusan',
            'description' => "Mengupdate jurusan: {$jurusan->nama_jurusan}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil diupdate',
            'data' => $jurusan
        ]);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $jurusan = Jurusan::findOrFail($id);
        $namaJurusan = $jurusan->nama_jurusan;
        $jurusan->delete();

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'delete_jurusan',
            'description' => "Menghapus jurusan: {$namaJurusan}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil dihapus'
        ]);
    }
}
