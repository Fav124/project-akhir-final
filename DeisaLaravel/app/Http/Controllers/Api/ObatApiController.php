<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Activity;
use Illuminate\Http\Request;

class ObatApiController extends Controller
{
    /**
     * Display a listing of obat
     */
    public function index(Request $request)
    {
        $query = Obat::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_obat', 'like', "%{$search}%");
        }

        // Filter by low stock
        if ($request->boolean('low_stock')) {
            $query->where('stok', '<', 10);
        }

        $perPage = $request->get('per_page', 20);
        $obat = $query->orderBy('nama_obat')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $obat->map(function ($o) {
                return [
                    'id' => $o->id,
                    'nama_obat' => $o->nama_obat,
                    'jenis' => $o->jenis,
                    'stok' => $o->stok,
                    'satuan' => $o->satuan,
                    'keterangan' => $o->keterangan,
                    'is_low_stock' => $o->stok < 10
                ];
            }),
            'meta' => [
                'current_page' => $obat->currentPage(),
                'last_page' => $obat->lastPage(),
                'per_page' => $obat->perPage(),
                'total' => $obat->total()
            ]
        ]);
    }

    /**
     * Store a newly created obat (Admin & Staff)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string'
        ]);

        $obat = Obat::create($validated);

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'create_obat',
            'description' => "Menambah obat: {$obat->nama_obat}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil ditambahkan',
            'data' => $obat
        ], 201);
    }

    /**
     * Display the specified obat
     */
    public function show($id)
    {
        $obat = Obat::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $obat->id,
                'nama_obat' => $obat->nama_obat,
                'jenis' => $obat->jenis,
                'stok' => $obat->stok,
                'satuan' => $obat->satuan,
                'keterangan' => $obat->keterangan,
                'is_low_stock' => $obat->stok < 10
            ]
        ]);
    }

    /**
     * Update the specified obat (Admin & Staff)
     */
    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string'
        ]);

        $obat->update($validated);

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'update_obat',
            'description' => "Mengupdate obat: {$obat->nama_obat}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil diupdate',
            'data' => $obat
        ]);
    }

    /**
     * Restock obat (Admin & Staff)
     */
    public function restock(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        $validated = $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $oldStok = $obat->stok;
        $obat->stok += $validated['jumlah'];
        $obat->save();

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'restock_obat',
            'description' => "Restock obat {$obat->nama_obat}: {$oldStok} → {$obat->stok}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil direstock',
            'data' => $obat
        ]);
    }

    /**
     * Remove the specified obat (Admin only)
     */
    public function destroy(Request $request, $id)
    {
        // Check if user is admin
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin only.'
            ], 403);
        }

        $obat = Obat::findOrFail($id);
        $namaObat = $obat->nama_obat;
        $obat->delete();

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'delete_obat',
            'description' => "Menghapus obat: {$namaObat}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil dihapus'
        ]);
    }
}
