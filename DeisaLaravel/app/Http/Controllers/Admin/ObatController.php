<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\ActivityLog; // Assuming you have this model
use Illuminate\Support\Facades\Auth;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $query = Obat::query();

        if ($request->has('search')) {
            $term = $request->search;
            $query->where('nama_obat', 'like', "%{$term}%")
                ->orWhere('kode_obat', 'like', "%{$term}%");
        }

        if ($request->has('filter') && $request->filter != '') {
            $f = $request->filter;
            $now = now();
            if ($f === 'kritis') {
                $query->whereRaw('stok <= stok_minimum');
            } elseif ($f === 'kadaluarsa') {
                $query->where('tanggal_kadaluarsa', '<', $now);
            } elseif ($f === 'aman') {
                $query->whereRaw('stok > stok_minimum')
                    ->where(function ($q) use ($now) {
                        $q->where('tanggal_kadaluarsa', '>=', $now)
                            ->orWhereNull('tanggal_kadaluarsa');
                    });
            }
        }

        $obats = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('admin.obat._table', compact('obats'));
        }

        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        // Generate Auto Code
        $lastObat = Obat::latest()->first();
        $nextId = $lastObat ? $lastObat->id + 1 : 1;
        $newKode = 'OBT-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        return view('admin.obat.create', compact('newKode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required',
            'satuan' => 'required',
            'stok' => 'required|integer|min:0',
            'stok_min' => 'required|integer|min:0',
            'harga' => 'nullable|numeric',
            'kadaluarsa' => 'nullable|date',
            'lokasi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048'
        ]);

        try {
            $obat = new Obat();
            $lastObat = Obat::latest()->first();
            $nextId = $lastObat ? $lastObat->id + 1 : 1;
            $obat->kode_obat = 'OBT-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            $obat->nama_obat = $validated['nama'];
            $obat->kategori = $validated['kategori'];
            $obat->satuan = $validated['satuan'];
            $obat->stok = $validated['stok'];
            $obat->stok_awal = $validated['stok'];
            $obat->stok_minimum = $validated['stok_min'];
            $obat->harga_satuan = $validated['harga'] ?? 0;
            $obat->tanggal_kadaluarsa = $validated['kadaluarsa'];
            $obat->lokasi_penyimpanan = $validated['lokasi'];

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('obat-photos', 'public');
                $obat->foto = $path;
            }

            $obat->save();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Obat berhasil ditambahkan', 'redirect' => route('admin.obat.index')]);
            }
            return redirect()->route('admin.obat.index')->with('success', 'Obat berhasil ditambahkan');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menambahkan obat: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menambahkan obat: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $obat = Obat::findOrFail($id);
        if (request()->ajax()) {
            return view('admin.obat._detail', compact('obat'));
        }
        return view('admin.obat.show', compact('obat'));
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        if (request()->ajax()) {
            return view('admin.obat._form_modal', compact('obat'));
        }
        return view('admin.obat.edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        try {
            $obat = Obat::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kategori' => 'required',
                'satuan' => 'required',
                'stok_min' => 'required|integer|min:0',
                'harga' => 'nullable|numeric',
                'kadaluarsa' => 'nullable|date',
                'lokasi' => 'nullable|string',
                'foto' => 'nullable|image|max:2048',
            ]);

            $obat->nama_obat = $validated['nama'];
            $obat->kategori = $validated['kategori'];
            $obat->satuan = $validated['satuan'];
            $obat->stok_minimum = $validated['stok_min'];
            $obat->harga_satuan = $validated['harga'] ?? 0;
            $obat->tanggal_kadaluarsa = $validated['kadaluarsa'];
            $obat->lokasi_penyimpanan = $validated['lokasi'];

            if ($request->hasFile('foto')) {
                // Delete old photo if exists
                if ($obat->foto && \Storage::disk('public')->exists($obat->foto)) {
                    \Storage::disk('public')->delete($obat->foto);
                }
                $path = $request->file('foto')->store('obat-photos', 'public');
                $obat->foto = $path;
            }

            $obat->save();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Data obat berhasil diperbarui', 'redirect' => route('admin.obat.index')]);
            }
            return redirect()->route('admin.obat.index')->with('success', 'Data obat berhasil diperbarui');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal update obat: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal update obat: ' . $e->getMessage())->withInput();
        }
    }

    public function restock(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        try {
            $obat = Obat::findOrFail($id);
            $obat->stok += $request->jumlah;
            $obat->save();

            // Log restock history here if table exists

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Stok berhasil ditambahkan', 'reload' => true]);
            }
            return redirect()->back()->with('success', 'Stok berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Restock gagal: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Restock gagal: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $obat = Obat::findOrFail($id);
            $obatName = $obat->nama_obat;
            $obat->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'DELETE',
                'module' => 'Obat',
                'detail' => "Menghapus data obat: {$obatName}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Obat berhasil dihapus', 'reload' => true]);
            }
            return redirect()->back()->with('success', 'Obat berhasil dihapus');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Hapus gagal: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Hapus gagal: ' . $e->getMessage());
        }
    }
}
