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
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal_mulai_sakit' => 'nullable|date',
            'tgl_masuk' => 'nullable|date',
            'status' => 'required',
            'keluhan' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'gejala' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'tingkat_kondisi' => 'nullable|string',
            'obat_ids' => 'nullable|array',
            'obat_ids.*' => 'exists:obats,id'
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // Fallback for tgl_masuk if only tanggal_mulai_sakit is provided
                $tglMasuk = $request->tgl_masuk ?? $request->tanggal_mulai_sakit ?? now();

                $record = SantriSakit::create([
                    'santri_id' => $request->santri_id,
                    'tgl_masuk' => $tglMasuk,
                    'tanggal_mulai_sakit' => $request->tanggal_mulai_sakit ?? $tglMasuk,
                    'status' => $request->status,
                    'keluhan' => $request->keluhan,
                    'diagnosis' => $request->diagnosis,
                    'gejala' => $request->gejala,
                    'tindakan' => $request->tindakan,
                    'tingkat_kondisi' => $request->tingkat_kondisi,
                    'jenis_perawatan' => $request->jenis_perawatan ?? 'UKS'
                ]);

                // Handle obat_ids (simplified Android version)
                if ($request->has('obat_ids')) {
                    foreach ($request->obat_ids as $obatId) {
                        PenggunaanObat::create([
                            'santri_sakit_id' => $record->id,
                            'obat_id' => $obatId,
                            'jumlah' => 1 // Default to 1 if not specified
                        ]);
                        
                        $obat = Obat::find($obatId);
                        if ($obat && $obat->stok > 0) {
                            $obat->decrement('stok', 1);
                        }
                    }
                }

                // Update Santri health status
                $santri = Santri::find($request->santri_id);
                $santri->update(['status_kesehatan' => $request->status]);

                return response()->json([
                    'success' => true,
                    'message' => 'Record created successfully',
                    'data' => $record->load('santri')
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating record: ' . $e->getMessage()
            ], 500);
        }
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

        return response()->json(['message' => 'Status updated to Sembuh']);
    }
}
