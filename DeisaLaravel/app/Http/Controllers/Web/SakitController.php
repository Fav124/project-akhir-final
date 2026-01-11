<?php

namespace App\Http\Controllers\Web;

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
        $records = SantriSakit::with(['santri', 'diagnoses'])->orderBy('created_at', 'desc')->paginate(15);
        return view('sakit.index', compact('records'));
    }

    public function create()
    {
        $santris = Santri::all();
        $obats = Obat::where('stok', '>', 0)->get();
        return view('sakit.create', compact('santris', 'obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal_mulai_sakit' => 'required|date',
            'status' => 'required',
            'keluhan' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'gejala' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'tingkat_kondisi' => 'nullable|string',
            'obat_ids' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {
            $record = SantriSakit::create([
                'santri_id' => $request->santri_id,
                'tgl_masuk' => $request->tanggal_mulai_sakit,
                'tanggal_mulai_sakit' => $request->tanggal_mulai_sakit,
                'status' => $request->status,
                'keluhan' => $request->keluhan,
                'diagnosis' => $request->diagnosis,
                'gejala' => $request->gejala,
                'tindakan' => $request->tindakan,
                'tingkat_kondisi' => $request->tingkat_kondisi,
                'jenis_perawatan' => $request->jenis_perawatan ?? 'UKS'
            ]);

            if ($request->has('obat_ids')) {
                foreach ($request->obat_ids as $obatId) {
                    PenggunaanObat::create([
                        'santri_sakit_id' => $record->id,
                        'obat_id' => $obatId,
                        'jumlah' => 1
                    ]);
                    $obat = Obat::find($obatId);
                    if ($obat && $obat->stok > 0) { $obat->decrement('stok', 1); }
                }
            }

            $santri = Santri::find($request->santri_id);
            $santri->update(['status_kesehatan' => $request->status]);
        });

        return redirect()->route('sakit.index')->with('success', 'Catatan sakit berhasil disimpan.');
    }

    public function markSembuh(SantriSakit $sakit)
    {
        DB::transaction(function () use ($sakit) {
            $sakit->update(['status' => 'Sembuh', 'tgl_sembuh' => now()]);
            $sakit->santri->update(['status_kesehatan' => 'Sehat']);
        });
        return back()->with('success', 'Santri ditandai sembuh.');
    }
}
