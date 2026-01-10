<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use App\Traits\InteractsWithDrafts;

class ObatController extends Controller
{
    use InteractsWithDrafts;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('json')) {
                return response()->json(Obat::orderBy('nama_obat', 'asc')->get());
            }
            $query = Obat::orderBy('nama_obat', 'asc');

            // Search
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_obat', 'LIKE', "%{$search}%")
                      ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                      ->orWhere('satuan', 'LIKE', "%{$search}%");
                });
            }

            // Filter Status
            if ($request->has('filter_status') && !empty($request->filter_status)) {
                $filter = $request->filter_status;
                $today = date('Y-m-d');
                $next3Months = date('Y-m-d', strtotime('+3 months'));

                switch ($filter) {
                    case 'kadaluarsa':
                        $query->where('tanggal_kadaluarsa', '<', $today);
                        break;
                    case 'hampir_kadaluarsa':
                        $query->whereBetween('tanggal_kadaluarsa', [$today, $next3Months]);
                        break;
                    case 'stok_sedikit':
                        $query->whereColumn('stok', '<=', 'stok_minimum');
                        break;
                    case 'aman':
                        $query->whereColumn('stok', '>', 'stok_minimum');
                        break;
                }
            }

            $obat = $query->paginate(10);
            return view('obat.table', compact('obat'))->render();
        }

        $obat = Obat::orderBy('nama_obat', 'asc')->paginate(10);
        return view('obat.index', compact('obat'));
    }

    // ========================
    // 📍 CREATE
    // ========================
    public function create()
    {
        return view('obat.create');
    }

    // ========================
    // 📍 STORE TEMPORARY (Draft)
    // ========================
    public function storeTemporary(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'nullable|numeric|min:0',
            'harga_satuan' => 'nullable|numeric|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
            'foto' => 'nullable|image|max:5120'
        ]);

        // Handle photo upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = \App\Helpers\PhotoHelper::store($request->file('foto'), 'obats');
        }

        $newData = $request->except(['foto']);
        $newData['foto'] = $fotoPath;

        $this->storeDraft('obat', $newData);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan ke draft! 🎉'
        ]);
    }

    // ========================
    // 📍 GET TEMPORARY
    // ========================
    public function getTemporary(Request $request)
    {
        if ($request->has('id')) {
            $item = $this->findDraft('obat', $request->get('id'));

            if (!$item) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }

            return response()->json($item);
        }

        return response()->json($this->getDrafts('obat'));
    }

    // ========================
    // 📍 UPDATE TEMPORARY
    // ========================
    public function updateTemporary(Request $request)
    {
        $request->validate([
            'edit_id' => 'required|string',
            'nama_obat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'nullable|numeric|min:0',
            'harga_satuan' => 'nullable|numeric|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
            'foto' => 'nullable|image|max:5120'
        ]);

        $editId = $request->input('edit_id');
        $item = $this->findDraft('obat', $editId);

        if (!$item) {
            return response()->json(['error' => 'Draft tidak ditemukan'], 404);
        }

        $fotoPath = $item['foto'] ?? null;
        if ($request->hasFile('foto')) {
            if ($fotoPath) {
                \App\Helpers\PhotoHelper::delete($fotoPath);
            }
            $fotoPath = \App\Helpers\PhotoHelper::store($request->file('foto'), 'obats');
        }

        $updateData = $request->except(['_token', 'edit_id', 'foto']);
        $updateData['foto'] = $fotoPath;

        $this->updateDraft('obat', $editId, $updateData);

        return response()->json([
            'success' => true,
            'message' => 'Draft berhasil diupdate! ✏️'
        ]);
    }

    // ========================
    // 📍 DELETE TEMPORARY
    // ========================
    public function deleteTemporary(Request $request)
    {
        $this->deleteDraft('obat', $request->input('id'));
        return response()->json(['success' => true]);
    }

    // ========================
    // 📍 SAVE ALL FROM DRAFT
    // ========================
    public function saveAll()
    {
        try {
            $drafts = $this->getDrafts('obat');

            if (empty($drafts)) {
                return back()->with('error', 'Tidak ada draft untuk disimpan.');
            }

            $savedCount = 0;

            foreach ($drafts as $data) {
                $validated = validator($data, [
                    'nama_obat' => 'required|string|max:100',
                    'deskripsi' => 'nullable|string',
                    'stok' => 'required|numeric|min:0',
                    'satuan' => 'required|string|max:50',
                    'stok_minimum' => 'nullable|numeric|min:0',
                    'harga_satuan' => 'nullable|numeric|min:0',
                    'tanggal_kadaluarsa' => 'nullable|date',
                    'foto' => 'nullable|string'
                ])->validate();

                Obat::create($validated);
                $savedCount++;
            }

            $this->clearDrafts('obat');

            return redirect()->route('obat.index')
                ->with('success', "Berhasil menyimpan {$savedCount} data obat ke database! 🎉");
        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan: ' . $e->getMessage());
        }
    }

    // ========================
    // 📍 STORE (Individual)
    // ========================
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'nullable|numeric|min:0',
            'harga_satuan' => 'nullable|numeric|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
            'foto' => 'nullable|image|max:5120'
        ]);

        $data = $request->all();
        if ($request->hasFile('foto')) {
            $data['foto'] = \App\Helpers\PhotoHelper::store($request->file('foto'), 'obats');
        }

        Obat::create($data);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan');
    }

    // ========================
    // 📍 EDIT
    // ========================
    public function edit(Obat $obat)
    {
        return view('obat.edit', compact('obat'));
    }

    // ========================
    // 📍 SHOW
    // ========================
    public function show(Obat $obat)
    {
        // Load recent usage history
        // Note: We'll retrieve usage via SakitSantri pivot for now as a simple history
        // Adjust if you have a dedicated 'obat_histories' table for stock mutations
        $riwayatPenggunaan = \DB::table('sakit_santri_obat')
            ->join('sakit_santris', 'sakit_santri_obat.sakit_santri_id', '=', 'sakit_santris.id')
            ->join('santris', 'sakit_santris.santri_id', '=', 'santris.id')
            ->where('sakit_santri_obat.obat_id', $obat->id)
            ->select('sakit_santris.tanggal_mulai_sakit', 'santris.nama_lengkap', 'sakit_santri_obat.jumlah', 'sakit_santri_obat.created_at')
            ->orderBy('sakit_santri_obat.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('obat.show', compact('obat', 'riwayatPenggunaan'));
    }

    // ========================
    // 📍 UPDATE
    // ========================
    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'nullable|numeric|min:0',
            'harga_satuan' => 'nullable|numeric|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
            'foto' => 'nullable|image|max:5120'
        ]);

        $data = $request->except(['foto']);
        if ($request->hasFile('foto')) {
            \App\Helpers\PhotoHelper::delete($obat->foto);
            $data['foto'] = \App\Helpers\PhotoHelper::store($request->file('foto'), 'obats');
        }

        $obat->update($data);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui');
    }

    // ========================
    // 📍 DELETE
    // ========================
    public function destroy(Obat $obat)
    {
        // Check if obat is being used
        if ($obat->sakitSantris()->count() > 0) {
            return redirect()->route('obat.index')
                ->with('error', 'Obat tidak dapat dihapus karena masih digunakan dalam data sakit santri.');
        }

        $obat->delete();
        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus');
    }

    // ========================
    // 📍 CHECK STOCK
    // ========================
    public function checkStock()
    {
        $lowStockObats = Obat::whereRaw('stok <= stok_minimum')->get();

        return response()->json([
            'success' => true,
            'low_stock_count' => $lowStockObats->count(),
            'obats' => $lowStockObats
        ]);
    }
}
