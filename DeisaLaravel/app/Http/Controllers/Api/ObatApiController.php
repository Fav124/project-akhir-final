<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ObatApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Obat::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_obat', 'like', "%{$search}%");
        }

        if ($request->boolean('low_stock')) {
            $query->whereColumn('stok', '<=', 'stok_minimum');
        }

        $obat = $query->orderBy('nama_obat')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data obat berhasil diambil',
            'data' => $obat->map(fn (Obat $item) => $this->transformObat($item))->values(),
        ]);
    }

    public function store(Request $request)
    {
        $payload = $this->normalizePayload($request);
        $validator = Validator::make($payload, [
            'nama_obat' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'stok_awal' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string'
        ]);
        $validated = $validator->validate();

        $obat = Obat::create($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'create_obat',
            'description' => "Menambah obat: {$obat->nama_obat}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil ditambahkan',
            'data' => $this->transformObat($obat),
        ], 201);
    }

    public function show($id)
    {
        $obat = Obat::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail obat berhasil diambil',
            'data' => $this->transformObat($obat),
        ]);
    }

    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        $payload = $this->normalizePayload($request);
        $validator = Validator::make($payload, [
            'nama_obat' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'stok_awal' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string'
        ]);
        $validated = $validator->validate();

        $obat->update($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'update_obat',
            'description' => "Mengupdate obat: {$obat->nama_obat}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil diupdate',
            'data' => $this->transformObat($obat),
        ]);
    }

    public function restock(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        $validated = $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $oldStok = $obat->stok;
        $obat->stok += $validated['jumlah'];
        $obat->save();

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'restock_obat',
            'description' => "Restock obat {$obat->nama_obat}: {$oldStok} → {$obat->stok}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil direstock',
            'data' => $this->transformObat($obat),
        ]);
    }

    public function destroy(Request $request, $id)
    {
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

    private function normalizePayload(Request $request): array
    {
        $stok = (int) $request->input('stok', 0);

        return [
            'nama_obat' => (string) $request->input('nama_obat', ''),
            'kategori' => (string) $request->input('jenis_obat', $request->input('kategori', 'Lainnya')),
            'stok' => $stok,
            'stok_awal' => (int) $request->input('stok_awal', $stok),
            'stok_minimum' => (int) $request->input('stok_minimal', $request->input('stok_minimum', 10)),
            'tanggal_kadaluarsa' => $request->input('tanggal_kadaluarsa'),
            'satuan' => (string) $request->input('satuan', 'Strip'),
            'deskripsi' => $request->input('keterangan', $request->input('deskripsi')),
        ];
    }

    private function transformObat(Obat $obat): array
    {
        return [
            'id' => (int) $obat->id,
            'nama_obat' => (string) ($obat->nama_obat ?? ''),
            'jenis_obat' => (string) ($obat->kategori ?? ''),
            'stok' => (int) ($obat->stok ?? 0),
            'stok_minimal' => (int) ($obat->stok_minimum ?? 0),
            'tanggal_kadaluarsa' => $obat->tanggal_kadaluarsa
                ? Carbon::parse($obat->tanggal_kadaluarsa)->toDateString()
                : '',
            'keterangan' => $obat->deskripsi,
        ];
    }
}
