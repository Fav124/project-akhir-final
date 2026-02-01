<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Activity;
use Illuminate\Http\Request;

class KelasApiController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return response()->json([
            'success' => true,
            'data' => $kelas->map(function ($k) {
                return [
                    'id' => $k->id,
                    'nama_kelas' => $k->nama_kelas,
                    'tingkat' => $k->tingkat ?? null
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
            'nama_kelas' => 'required|string|max:255|unique:kelas',
            'tingkat' => 'nullable|string|max:50'
        ]);

        $kelas = Kelas::create($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'create_kelas',
            'description' => "Menambah kelas: {$kelas->nama_kelas}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil ditambahkan',
            'data' => $kelas
        ], 201);
    }

    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        return response()->json(['success' => true, 'data' => $kelas]);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $id,
            'tingkat' => 'nullable|string|max:50'
        ]);

        $kelas->update($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'update_kelas',
            'description' => "Mengupdate kelas: {$kelas->nama_kelas}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil diupdate',
            'data' => $kelas
        ]);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $kelas = Kelas::findOrFail($id);
        $namaKelas = $kelas->nama_kelas;
        $kelas->delete();

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'delete_kelas',
            'description' => "Menghapus kelas: {$namaKelas}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus'
        ]);
    }
}
