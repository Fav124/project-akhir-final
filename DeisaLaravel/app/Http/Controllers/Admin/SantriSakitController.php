<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SantriSakitController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\SantriSakit::with(['santri', 'santri.kelas']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $term = $request->search;
            $query->whereHas('santri', function ($q) use ($term) {
                $q->where('nama_lengkap', 'like', "%{$term}%")
                    ->orWhere('nis', 'like', "%{$term}%");
            });
        }

        $records = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('admin.sakit._table', compact('records'));
        }

        return view('admin.sakit.index', compact('records'));
    }

    public function show($id)
    {
        $record = \App\Models\SantriSakit::with(['santri', 'santri.kelas', 'santri.wali', 'obats'])->findOrFail($id);
        if (request()->ajax()) {
            return view('admin.sakit._detail', compact('record'));
        }
        return view('admin.sakit.show', compact('record'));
    }

    public function create()
    {
        $santris = \App\Models\Santri::with('kelas')->get();
        $obats = \App\Models\Obat::where('stok', '>', 0)->get();
        $diagnoses = \App\Models\Diagnosis::all();
        if (request()->ajax()) {
            return view('admin.sakit._form_modal', compact('santris', 'obats', 'diagnoses'));
        }
        return view('admin.sakit.create', compact('santris', 'obats', 'diagnoses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tgl_masuk' => 'required|date',
            'diagnosis_utama' => 'required|string|max:255',
            'gejala' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:Sakit,Pulang,Sembuh',
            'jenis_perawatan' => 'required|in:UKS,Rumah Sakit,Pulang',
            'tujuan_rujukan' => 'nullable|string',
            'obat_ids' => 'nullable|array',
            'obat_ids.*' => 'exists:obats,id',
            'obat_jumlahs' => 'nullable|array',
        ]);

        try {
            \DB::beginTransaction();

            $record = \App\Models\SantriSakit::create($validated);

            // Handle Medicine Usage
            if ($request->filled('obat_ids')) {
                foreach ($request->obat_ids as $index => $obatId) {
                    $jumlah = $request->obat_jumlahs[$index] ?? 1;
                    $obat = \App\Models\Obat::findOrFail($obatId);

                    if ($obat->stok < $jumlah) {
                        throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi.");
                    }

                    $record->obats()->attach($obatId, [
                        'jumlah' => $jumlah,
                        'satuan' => $obat->satuan,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    $obat->decrement('stok', $jumlah);
                }
            }

            // Sync Santri Status
            $santriStatus = $request->status == 'Sembuh' ? 'sehat' : 'sakit';
            $record->santri->update(['status_kesehatan' => $santriStatus]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'CREATE',
                'module' => 'Santri Sakit',
                'detail' => "Menambahkan riwayat sakit untuk santri: {$record->santri->nama_lengkap}",
                'ip_address' => request()->ip()
            ]);

            \DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Laporan sakit berhasil disimpan', 'reload' => true]);
            }
            return redirect()->route('admin.sakit.index')->with('success', 'Laporan sakit berhasil disimpan');
        } catch (\Exception $e) {
            \DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $record = \App\Models\SantriSakit::with('obats')->findOrFail($id);
        $santris = \App\Models\Santri::with('kelas')->get();
        $obats = \App\Models\Obat::all();
        $diagnoses = \App\Models\Diagnosis::all();
        if (request()->ajax()) {
            return view('admin.sakit._form_modal', compact('record', 'santris', 'obats', 'diagnoses'));
        }
        return view('admin.sakit.edit', compact('record', 'santris', 'obats', 'diagnoses'));
    }

    public function update(Request $request, $id)
    {
        $record = \App\Models\SantriSakit::findOrFail($id);
        $validated = $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tgl_masuk' => 'required|date',
            'diagnosis_utama' => 'required|string|max:255',
            'gejala' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:Sakit,Pulang,Sembuh',
            'jenis_perawatan' => 'required|in:UKS,Rumah Sakit,Pulang',
            'tujuan_rujukan' => 'nullable|string',
            'obat_ids' => 'nullable|array',
            'obat_jumlahs' => 'nullable|array',
        ]);

        try {
            \DB::beginTransaction();

            // Restore Stock from old usage
            foreach ($record->obats as $oldObat) {
                $oldObat->increment('stok', $oldObat->pivot->jumlah);
            }
            $record->obats()->detach();

            $record->update($validated);

            // Handle New Medicine Usage
            if ($request->filled('obat_ids')) {
                foreach ($request->obat_ids as $index => $obatId) {
                    $jumlah = $request->obat_jumlahs[$index] ?? 1;
                    $obat = \App\Models\Obat::findOrFail($obatId);

                    if ($obat->stok < $jumlah) {
                        throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi.");
                    }

                    $record->obats()->attach($obatId, [
                        'jumlah' => $jumlah,
                        'satuan' => $obat->satuan,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    $obat->decrement('stok', $jumlah);
                }
            }

            // Sync Santri Status
            $santriStatus = $request->status == 'Sembuh' ? 'sehat' : 'sakit';
            $record->santri->update(['status_kesehatan' => $santriStatus]);

            if ($request->status == 'Sembuh' && !$record->tgl_sembuh) {
                $record->update(['tgl_sembuh' => now()]);
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'UPDATE',
                'module' => 'Santri Sakit',
                'detail' => "Memperbarui riwayat sakit santri: {$record->santri->nama_lengkap}",
                'ip_address' => request()->ip()
            ]);

            \DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Data berhasil diperbarui', 'reload' => true]);
            }
            return redirect()->route('admin.sakit.index')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            \DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function setStatus(Request $request, $id, $status)
    {
        $record = \App\Models\SantriSakit::findOrFail($id);
        try {
            \DB::beginTransaction();

            $updateData = ['status' => $status];
            if ($status == 'Sembuh') {
                $updateData['tgl_sembuh'] = now();
                $record->santri->update(['status_kesehatan' => 'sehat']);
            } elseif ($status == 'Pulang') {
                $updateData['jenis_perawatan'] = 'Pulang';
                $record->santri->update(['status_kesehatan' => 'pemulihan']);
            } elseif ($status == 'Sakit') {
                // Return from Pulang
                $record->santri->update(['status_kesehatan' => 'sakit']);
            }

            $record->update($updateData);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'UPDATE_STATUS',
                'module' => 'Santri Sakit',
                'detail' => "Mengubah status sakit santri {$record->santri->nama_lengkap} menjadi $status",
                'ip_address' => request()->ip()
            ]);

            \DB::commit();
            return response()->json(['message' => "Status berhasil diubah ke $status", 'reload' => true]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            \DB::beginTransaction();
            $record = \App\Models\SantriSakit::findOrFail($id);

            // Restore Stock
            foreach ($record->obats as $obat) {
                $obat->increment('stok', $obat->pivot->jumlah);
            }

            $record->santri->update(['status_kesehatan' => 'sehat']);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'DELETE',
                'module' => 'Santri Sakit',
                'detail' => "Menghapus riwayat sakit santri: {$record->santri->nama_lengkap}",
                'ip_address' => request()->ip()
            ]);

            $record->delete();

            \DB::commit();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Data riwayat berhasil dihapus (stok dipulihkan)', 'reload' => true]);
            }
            return redirect()->back()->with('success', 'Data riwayat berhasil dihapus');
        } catch (\Exception $e) {
            \DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
