<?php

namespace App\Http\Controllers;

use App\Models\SakitSantri;
use App\Models\Santri;
use App\Models\Obat;
use App\Models\Diagnosis;
use Illuminate\Http\Request;
use App\Traits\InteractsWithDrafts;

class SakitController extends Controller
{
    use InteractsWithDrafts;
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ========================
    // 📍 INDEX
    // ========================
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = SakitSantri::with(['santri', 'santri.kelas', 'obats'])->orderBy('id', 'desc');

            // Filter Status
            if ($request->has('filter_status') && !empty($request->filter_status)) {
                $query->where('status', $request->filter_status);
            }

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->whereHas('santri', function($q) use ($search) {
                        $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                          ->orWhere('nis', 'LIKE', "%{$search}%");
                    })->orWhere('diagnosis', 'LIKE', "%{$search}%")
                      ->orWhere('status', 'LIKE', "%{$search}%");
                });
            }

            $sakit = $query->paginate(10);
            return view('sakit.table', compact('sakit'))->render();
        }

        $sakit = SakitSantri::with(['santri', 'santri.kelas', 'obats'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        $obats = Obat::all();

        return view('sakit.index', compact('sakit', 'obats'));
    }

    // ========================
    // 📍 CREATE
    // ========================
    public function create()
    {
        $santri = Santri::all();
        $obats = Obat::all();
        $allDiagnoses = Diagnosis::all();
        $kelas = Kelas::all();
        return view('sakit.create', compact('santri', 'obats', 'allDiagnoses', 'kelas'));
    }

    // ========================
    // 📍 STORE TEMPORARY (Draft)
    // ========================
    public function storeTemporary(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal_mulai_sakit' => 'required|date',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'required|string',
            'suhu_tubuh' => 'nullable|numeric',
            'status' => 'required|in:sakit,sembuh,kontrol',
            'tanggal_selesai_sakit' => 'nullable|date',
            'catatan' => 'nullable|string',
            'obat_data' => 'nullable|array',
            'diagnoses' => 'nullable|array' // Array of names
        ]);

        $this->storeDraft('sakit', $request->all());

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
            $item = $this->findDraft('sakit', $request->get('id'));

            if (!$item) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }

            // Load santri data
            $item['santri'] = Santri::find($item['santri_id']);

            return response()->json($item);
        }

        return response()->json($this->getDrafts('sakit'));
    }

    // ========================
    // 📍 UPDATE TEMPORARY
    // ========================
    public function updateTemporary(Request $request)
    {
        $request->validate([
            'edit_id' => 'required|string',
            'santri_id' => 'required|exists:santris,id',
            'tanggal_mulai_sakit' => 'required|date',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'required|string',
            'suhu_tubuh' => 'nullable|numeric',
            'status' => 'required|in:sakit,sembuh,kontrol',
            'tanggal_selesai_sakit' => 'nullable|date',
            'catatan' => 'nullable|string',
            'obat_data' => 'nullable|array',
            'diagnoses' => 'nullable|array'
        ]);

        $this->updateDraft('sakit', $request->input('edit_id'), $request->except(['_token', 'edit_id']));

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
        $this->deleteDraft('sakit', $request->input('id'));
        return response()->json(['success' => true]);
    }

    // ========================
    // 📍 SAVE ALL FROM DRAFT
    // ========================
    public function saveAll()
    {
        try {
            $drafts = $this->getDrafts('sakit');

            if (empty($drafts)) {
                return back()->with('error', 'Tidak ada draft untuk disimpan.');
            }

            $savedCount = 0;

            foreach ($drafts as $data) {
                $validated = validator($data, [
                    'santri_id' => 'required|exists:santris,id',
                    'tanggal_mulai_sakit' => 'required|date',
                    'gejala' => 'required|string',
                    'tindakan' => 'required|string',
                    'resep_obat' => 'required|string',
                    'suhu_tubuh' => 'nullable|numeric',
                    'status' => 'required|in:sakit,sembuh,kontrol',
                    'tanggal_selesai_sakit' => 'nullable|date',
                    'catatan' => 'nullable|string'
                ])->validate();

                $diagnosesNames = $data['diagnoses'] ?? [];
                $validated['diagnosis'] = implode(', ', $diagnosesNames);

                $sakit = SakitSantri::create($validated);

                // Sync Diagnoses (Tags)
                if (!empty($diagnosesNames)) {
                    $diagnosisIds = [];
                    foreach ($diagnosesNames as $name) {
                        $diag = Diagnosis::firstOrCreate(['nama' => trim($name)]);
                        $diagnosisIds[] = $diag->id;
                    }
                    $sakit->diagnoses()->sync($diagnosisIds);
                }

                $medicineData = $this->prepareMedicineData($data['obat_data'] ?? []);
                foreach ($medicineData as $obatId => $pivot) {
                    $sakit->obats()->attach($obatId, $pivot);

                    $obat = Obat::find($obatId);
                    if ($obat) {
                        $obat->reduceStock($pivot['jumlah']);
                    }
                }

                $savedCount++;
            }

            $this->clearDrafts('sakit');

            return redirect()->route('sakit.index')
                ->with('success', "Berhasil menyimpan {$savedCount} data sakit santri ke database! 🎉");
        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan: ' . $e->getMessage());
        }
    }

    // ========================
    // 📍 STORE (Individual Save)
    // ========================
    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal_mulai_sakit' => 'required|date',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'required|string',
            'suhu_tubuh' => 'nullable|numeric',
            'status' => 'required|in:sakit,sembuh,kontrol',
            'tanggal_selesai_sakit' => 'nullable|date',
            'catatan' => 'nullable|string',
            'diagnoses' => 'nullable|array',
            'obat_data' => 'nullable|array'
        ]);

        $data = $request->all();
        $diagnosesNames = $request->input('diagnoses', []);
        $data['diagnosis'] = implode(', ', $diagnosesNames);
        $data['user_id'] = auth()->id();

        $sakit = SakitSantri::create($data);

        // Sync Diagnoses (Tags)
        if (!empty($diagnosesNames)) {
            $diagnosisIds = [];
            foreach ($diagnosesNames as $name) {
                $diag = Diagnosis::firstOrCreate(['nama' => trim($name)]);
                $diagnosisIds[] = $diag->id;
            }
            $sakit->diagnoses()->sync($diagnosisIds);
        }

    // Simpan obat dan potong stok
    $medicineData = $this->prepareMedicineData($request->input('obat_data', []));
    foreach ($medicineData as $id => $pivot) {
        $sakit->obats()->attach($id, $pivot);
        
        // Potong stok
        $obat = Obat::find($id);
        if ($obat) {
            $obat->reduceStock($pivot['jumlah']);
        }
    }

        // Update santri status to 'sakit'
        Santri::find($request->santri_id)->update(['status' => 'sakit']);

        return redirect()->route('sakit.index')->with('success', 'Data sakit santri berhasil disimpan');
    }

    // ========================
    // 📍 EDIT
    // ========================
    public function edit(SakitSantri $sakit)
    {
        $santri = Santri::all();
        $obats = Obat::all();
        $sakit->load(['santri', 'obats', 'diagnoses']);
        return view('sakit.edit', compact('sakit', 'santri', 'obats'));
    }

    // ========================
    // 📍 SHOW
    // ========================
    public function show(SakitSantri $sakit)
    {
        $sakit->load(['santri.kelas', 'obats', 'user']); // Assuming 'user' is the petugas
        return view('sakit.show', compact('sakit'));
    }

    // ========================
    // 📍 UPDATE
    // ========================
    public function update(Request $request, SakitSantri $sakit)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal_mulai_sakit' => 'required|date',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'required|string',
            'suhu_tubuh' => 'nullable|numeric',
            'status' => 'required|in:sakit,sembuh,kontrol',
            'tanggal_selesai_sakit' => 'nullable|date',
            'catatan' => 'nullable|string',
            'diagnoses' => 'nullable|array',
            'obat_data' => 'nullable|array'
        ]);

        $data = $request->all();
        $diagnosesNames = $request->input('diagnoses', []);
        $data['diagnosis'] = implode(', ', $diagnosesNames); 

        $sakit->update($data);

        // Sync Diagnoses (Tags)
        $diagnosisIds = [];
        foreach ($diagnosesNames as $name) {
            $diag = Diagnosis::firstOrCreate(['nama' => trim($name)]);
            $diagnosisIds[] = $diag->id;
        }
        $sakit->diagnoses()->sync($diagnosisIds);

    // --- STOCK MANAGEMENT ---
    // 1. Restore previous stock and usage counts for this record before update
    foreach ($sakit->obats as $oldObat) {
        $oldObat->restoreStock($oldObat->pivot->jumlah);
    }

    // 2. Prepare and group new medication data
    $medicineData = $this->prepareMedicineData($request->input('obat_data', []));

    // 3. Sync Medicines and deduct new stock
    foreach ($medicineData as $id => $pivot) {
        $newObat = Obat::find($id);
        if ($newObat) {
            $newObat->reduceStock($pivot['jumlah']);
        }
    }
    $sakit->obats()->sync($medicineData);

        return redirect()->route('sakit.index')
            ->with('success', 'Data sakit berhasil diperbarui!');
    }

    // ========================
    // 📍 MARK RECOVERED
    // ========================
    public function markRecovered(SakitSantri $sakit)
    {
        $sakit->update([
            'status' => 'sembuh',
            'tanggal_selesai_sakit' => now()->toDateString()
        ]);

        // Update santri status back to 'sehat'
        Santri::find($sakit->santri_id)->update(['status' => 'sehat']);

        return redirect()->route('sakit.index')->with('success', 'Status santri berhasil diperbarui menjadi sembuh');
    }

    // ========================
    // 📍 GET MEDICINES (JSON)
    // ========================
    public function getMedicines(SakitSantri $sakit)
    {
        return response()->json($sakit->obats()->get()->map(function($obat) {
            return [
                'obat_id' => $obat->id,
                'nama_obat' => $obat->nama_obat,
                'satuan' => $obat->satuan,
                'jumlah' => $obat->pivot->jumlah,
                'dosis' => $obat->pivot->dosis,
                'keterangan' => $obat->pivot->keterangan
            ];
        }));
    }

    // ========================
    // 📍 SYNC MEDICINES
    // ========================
    public function syncMedicines(Request $request, SakitSantri $sakit)
    {
        $request->validate([
            'obat_data' => 'nullable|array'
        ]);

    // 1. Restore previous stock and usage counts
    foreach ($sakit->obats as $oldObat) {
        $oldObat->restoreStock($oldObat->pivot->jumlah);
    }

    // 2. Prepare / group new medicine data
    $medicineData = $this->prepareMedicineData($request->input('obat_data', []));

    // 3. Sync and deduct
    foreach ($medicineData as $id => $pivot) {
        $newObat = Obat::find($id);
        if ($newObat) {
            $newObat->reduceStock($pivot['jumlah']);
        }
    }
    $sakit->obats()->sync($medicineData);

        return response()->json([
            'success' => true,
            'message' => 'Data obat berhasil diperbarui!'
        ]);
    }

    // ========================
    // 📍 DELETE
    // ========================
    public function destroy(SakitSantri $sakit)
    {
        // Restore stock before deleting the record
        foreach ($sakit->obats as $obat) {
            $obat->restoreStock($obat->pivot->jumlah);
        }

        $sakit->delete();
        return redirect()->route('sakit.index')->with('success', 'Data sakit santri berhasil dihapus');
    }

    /**
     * Helper to group medicine data by ID and prevent duplicate deductions
     */
    private function prepareMedicineData($rawItems)
    {
        $grouped = [];
        if (!is_array($rawItems)) return $grouped;

        foreach ($rawItems as $item) {
            if (empty($item['obat_id'])) continue;
            
            $id = $item['obat_id'];
            if (!isset($grouped[$id])) {
                $grouped[$id] = [
                    'jumlah' => 0,
                    'dosis' => $item['dosis'] ?? null,
                    'keterangan' => $item['keterangan'] ?? null,
                ];
            }
            
            $grouped[$id]['jumlah'] += (int)($item['jumlah'] ?? 0);
            
            // Overwrite dosis/keterangan with latest non-empty if multiple entries
            if (!empty($item['dosis'])) $grouped[$id]['dosis'] = $item['dosis'];
            if (!empty($item['keterangan'])) $grouped[$id]['keterangan'] = $item['keterangan'];
        }
        
        return $grouped;
    }
}
