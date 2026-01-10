<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\ObatHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ObatController extends Controller
{
    /**
     * Get list of obat with filters
     * 
     * GET /api/obats
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Obat::query();

        // Search by name
        if ($request->has('search')) {
            $query->where('nama_obat', 'like', '%' . $request->search . '%');
        }

        // Filter low stock
        if ($request->has('low_stock') && $request->low_stock) {
            $query->lowStock();
        }

        // Filter expiring soon
        if ($request->has('expiring_soon') && $request->expiring_soon) {
            $days = $request->get('expiring_days', 30);
            $query->expiringSoon($days);
        }

        // Filter expired
        if ($request->has('expired') && $request->expired) {
            $query->expired();
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'nama_obat');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $obats = $query->paginate($perPage);

        // Add alerts to each obat
        $items = collect($obats->items())->map(function ($obat) {
            return [
                'id' => $obat->id,
                'nama_obat' => $obat->nama_obat,
                'foto' => $obat->foto_url,
                'deskripsi' => $obat->deskripsi,
                'stok' => $obat->stok,
                'satuan' => $obat->satuan,
                'stok_minimum' => $obat->stok_minimum,
                'harga_satuan' => $obat->harga_satuan,
                'tanggal_kadaluarsa' => $obat->tanggal_kadaluarsa?->format('Y-m-d'),
                'alerts' => [
                    'low_stock' => $obat->isStockLow(),
                    'expiring_soon' => $obat->isExpiringSoon(),
                    'expired' => $obat->isExpired()
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $items,
            'meta' => [
                'current_page' => $obats->currentPage(),
                'last_page' => $obats->lastPage(),
                'per_page' => $obats->perPage(),
                'total' => $obats->total()
            ]
        ]);
    }

    /**
     * Get single obat with history
     * 
     * GET /api/obats/{id}
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $obat = Obat::with('histories')->findOrFail($id);

        // Calculate usage statistics
        $usageCount = $obat->sakitSantris()->count();
        $totalUsed = $obat->sakitSantris()->sum('sakit_santri_obat.jumlah');

        return response()->json([
            'success' => true,
            'data' => [
                'obat' => [
                    'id' => $obat->id,
                    'nama_obat' => $obat->nama_obat,
                    'foto' => $obat->foto_url,
                    'deskripsi' => $obat->deskripsi,
                    'stok' => $obat->stok,
                    'satuan' => $obat->satuan,
                    'stok_minimum' => $obat->stok_minimum,
                    'harga_satuan' => $obat->harga_satuan,
                    'tanggal_kadaluarsa' => $obat->tanggal_kadaluarsa?->format('Y-m-d'),
                    'alerts' => [
                        'low_stock' => $obat->isStockLow(),
                        'expiring_soon' => $obat->isExpiringSoon(),
                        'expired' => $obat->isExpired()
                    ]
                ],
                'statistics' => [
                    'usage_count' => $usageCount,
                    'total_used' => $totalUsed
                ],
                'purchase_history' => $obat->histories()->orderBy('tanggal_pembelian', 'desc')->limit(10)->get()
            ]
        ]);
    }

    /**
     * Create new obat
     * 
     * POST /api/obats
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'nullable|integer|min:0',
            'harga_satuan' => 'nullable|numeric|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only([
            'nama_obat', 'deskripsi', 'stok', 'satuan',
            'stok_minimum', 'harga_satuan', 'tanggal_kadaluarsa'
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = 'obat_' . time() . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('obats', $filename, 'public');
            $data['foto'] = $path;
        }

        $obat = Obat::create($data);

        // Create initial stock history if stok > 0
        if ($obat->stok > 0) {
            ObatHistory::create([
                'obat_id' => $obat->id,
                'tanggal_pembelian' => now()->toDateString(),
                'jumlah' => $obat->stok,
                'keterangan' => 'Stok awal'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil ditambahkan',
            'data' => $obat
        ], 201);
    }

    /**
     * Update obat
     * 
     * PUT /api/obats/{id}
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        $request->validate([
            'nama_obat' => 'sometimes|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'sometimes|integer|min:0',
            'satuan' => 'sometimes|string|max:50',
            'stok_minimum' => 'nullable|integer|min:0',
            'harga_satuan' => 'nullable|numeric|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only([
            'nama_obat', 'deskripsi', 'stok', 'satuan',
            'stok_minimum', 'harga_satuan', 'tanggal_kadaluarsa'
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($obat->foto) {
                Storage::disk('public')->delete($obat->foto);
            }
            
            $foto = $request->file('foto');
            $filename = 'obat_' . $obat->id . '_' . time() . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('obats', $filename, 'public');
            $data['foto'] = $path;
        }

        $obat->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil diperbarui',
            'data' => $obat->fresh()
        ]);
    }

    /**
     * Delete obat
     * 
     * DELETE /api/obats/{id}
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);

        // Check if obat is being used
        if ($obat->sakitSantris()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Obat tidak dapat dihapus karena masih digunakan dalam data sakit santri'
            ], 422);
        }

        // Delete foto
        if ($obat->foto) {
            Storage::disk('public')->delete($obat->foto);
        }

        // Delete histories
        $obat->histories()->delete();

        $obat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil dihapus'
        ]);
    }

    /**
     * Add purchase history (restock)
     * 
     * POST /api/obats/{id}/restock
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restock(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'tanggal_pembelian' => 'required|date',
            'supplier' => 'nullable|string|max:255',
            'harga_total' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        // Create history
        $history = ObatHistory::create([
            'obat_id' => $obat->id,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'jumlah' => $request->jumlah,
            'supplier' => $request->supplier,
            'harga_total' => $request->harga_total,
            'keterangan' => $request->keterangan
        ]);

        // Add stock
        $obat->addStock($request->jumlah);

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil ditambahkan',
            'data' => [
                'obat' => $obat->fresh(),
                'history' => $history
            ]
        ]);
    }

    /**
     * Get expiring medicines
     * 
     * GET /api/obats/expiring
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function expiring(Request $request)
    {
        $days = $request->get('days', 30);
        
        $expiring = Obat::expiringSoon($days)
            ->orderBy('tanggal_kadaluarsa', 'asc')
            ->get();

        $expired = Obat::expired()
            ->orderBy('tanggal_kadaluarsa', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'expiring_soon' => $expiring,
                'expired' => $expired
            ]
        ]);
    }

    /**
     * Get low stock medicines
     * 
     * GET /api/obats/low-stock
     * @return \Illuminate\Http\JsonResponse
     */
    public function lowStock()
    {
        $lowStock = Obat::lowStock()
            ->orderBy('stok', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $lowStock
        ]);
    }
}
