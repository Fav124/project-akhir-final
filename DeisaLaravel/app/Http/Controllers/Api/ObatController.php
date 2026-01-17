<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\PenggunaanObat;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $showAll = $request->query('all', false);

        $query = Obat::query();

        if (!$showAll) {
            $query->where('stok', '>', 0);
        }

        if ($search) {
            $query->where('nama_obat', 'LIKE', "%{$search}%");
        }

        $obats = $query->get();
        return response()->json([
            'success' => true,
            'data' => $obats
        ]);
    }

    public function show($id)
    {
        $obat = Obat::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $obat
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string',
            'stok' => 'required|integer',
            'satuan' => 'required|string',
        ]);

        $obat = Obat::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil ditambahkan',
            'data' => $obat
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil diperbarui',
            'data' => $obat
        ]);
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil dihapus'
        ]);
    }

    public function use(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'santri_id' => 'required|exists:santris,id', // Make sure santri exists
            'user_id' => 'sometimes'
        ]);

        $obat = Obat::findOrFail($id);

        if ($obat->stok < $request->jumlah) {
            return response()->json(['message' => 'Stok tidak cukup'], 400);
        }

        DB::transaction(function () use ($obat, $request) {
            $obat->decrement('stok', $request->jumlah);

            // Record usage
            PenggunaanObat::create([
                'obat_id' => $obat->id,
                'santri_id' => $request->santri_id,
                'jumlah' => $request->jumlah,
                'keterangan' => 'Via Android App',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return response()->json(['message' => 'Obat berhasil digunakan', 'new_stock' => $obat->stok]);
    }
}
