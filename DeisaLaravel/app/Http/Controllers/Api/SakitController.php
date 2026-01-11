<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SantriSakit;
use App\Models\Santri;
use App\Models\Obat;
use App\Models\PenggunaanObat;
use Illuminate\Support\Facades\DB;

class SakitController extends Controller
{
    public function index()
    {
        $records = SantriSakit::with(['santri', 'diagnoses', 'obats'])->orderBy('created_at', 'desc')->paginate(15);
        return response()->json($records);
    }

    public function store(Request $request)
    {
        // Aligning with Android SakitRequest format
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tgl_masuk' => 'required|date',
            'status' => 'required',
            'jenis_perawatan' => 'required',
            'tujuan_rujukan' => 'nullable|string',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'catatan' => 'nullable|string',
            'diagnosis_ids' => 'nullable|array',
            'diagnosis_ids.*' => 'exists:diagnoses,id',
            'obat_usage' => 'nullable|array',
            'obat_usage.*.obat_id' => 'required|exists:obats,id',
            'obat_usage.*.jumlah' => 'required|integer|min:1'
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $record = SantriSakit::create([
                    'santri_id' => $request->santri_id,
                    'tgl_masuk' => $request->tgl_masuk,
                    'status' => $request->status,
                    'jenis_perawatan' => $request->jenis_perawatan,
                    'tujuan_rujukan' => $request->tujuan_rujukan,
                    'gejala' => $request->gejala,
                    'tindakan' => $request->tindakan,
                    'catatan' => $request->catatan,
                    // Backward compatibility fields if needed
                    'tanggal_mulai_sakit' => $request->tgl_masuk,
                    'keluhan' => $request->gejala,
                ]);

                // Attach Diagnosis IDs
                if ($request->has('diagnosis_ids')) {
                    $record->diagnoses()->attach($request->diagnosis_ids);
                }

                // Handle Medicine Usage
                if ($request->has('obat_usage')) {
                    foreach ($request->obat_usage as $usage) {
                        PenggunaanObat::create([
                            'santri_sakit_id' => $record->id,
                            'obat_id' => $usage['obat_id'],
                            'jumlah' => $usage['jumlah'],
                            'satuan' => 'Unit' // Default or fetch from Obat model
                        ]);
                        
                        $obat = Obat::find($usage['obat_id']);
                        if ($obat && $obat->stok >= $usage['jumlah']) {
                            $obat->decrement('stok', $usage['jumlah']);
                        }
                    }
                }

                // Update Santri health status
                $santri = Santri::find($request->santri_id);
                if ($santri) {
                    $santri->update(['status_kesehatan' => $request->status]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Record created successfully',
                    'data' => $record->load(['santri', 'diagnoses', 'obats'])
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating record: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $record = SantriSakit::with(['santri', 'diagnoses', 'obats'])->findOrFail($id);
        return response()->json(['data' => $record]);
    }

    public function markSembuh($id)
    {
        $record = SantriSakit::findOrFail($id);
        
        DB::transaction(function () use ($record) {
            $record->update([
                'status' => 'Sembuh',
                'tgl_sembuh' => now()
            ]);
            $record->santri->update(['status_kesehatan' => 'Sehat']);
        });

        return response()->json(['success' => true, 'message' => 'Status updated to Sembuh']);
    }

    public function destroy($id)
    {
        $record = SantriSakit::findOrFail($id);
        $record->delete();
        return response()->json(['success' => true, 'message' => 'Deleted']);
    }
}
