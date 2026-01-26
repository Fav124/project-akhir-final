<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SantriSakit;
use App\Models\Santri;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SantriSakitController extends Controller
{
    public function create()
    {
        $obats = \App\Models\Obat::where('stok', '>', 0)->get();
        $santris = \App\Models\Santri::all(['nis', 'nama_lengkap']);
        return view('forms.sakit', compact('obats', 'santris'));
    }

    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'santri_id_input' => 'required', // This can be NIS or Name
            'keluhan' => 'required|string',
            'diagnosis_awal' => 'required|string',
            'tindakan' => 'required|string',
            'obat' => 'nullable|array',
            'obat.*.id' => 'nullable|exists:obats,id',
            'obat.*.jumlah' => 'nullable|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $santri = Santri::where('nis', $request->santri_id_input)
                ->orWhere('nama_lengkap', 'like', "%{$request->santri_id_input}%")
                ->first();

            if (!$santri) {
                throw new \Exception("Santri dengan identitas '{$request->santri_id_input}' tidak ditemukan.");
            }

            $sakit = new SantriSakit();
            $sakit->santri_id = $santri->id;
            $sakit->keluhan = $request->keluhan;
            $sakit->diagnosis_utama = $request->diagnosis_awal;
            $sakit->tindakan = $request->tindakan;
            $sakit->status = 'sakit';
            $sakit->tanggal_mulai_sakit = now();
            $sakit->save();

            // 2. Handle Medicines
            if ($request->has('obat')) {
                foreach ($request->obat as $obatItem) {
                    $obatRecord = \App\Models\Obat::findOrFail($obatItem['id']);

                    if ($obatRecord->stok < $obatItem['jumlah']) {
                        throw new \Exception("Stok obat '{$obatRecord->nama_obat}' tidak mencukupi (Sisa: {$obatRecord->stok}).");
                    }

                    // Record usage
                    \App\Models\PenggunaanObat::create([
                        'santri_sakit_id' => $sakit->id,
                        'obat_id' => $obatRecord->id,
                        'jumlah' => $obatItem['jumlah'],
                        'satuan' => $obatRecord->satuan ?? 'pcs'
                    ]);

                    // Deduct stock
                    $obatRecord->decrement('stok', $obatItem['jumlah']);
                }
            }

            // 3. Log Activity
            if (auth()->check()) {
                \App\Models\ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'create',
                    'module' => 'Santri Sakit',
                    'detail' => "Mencatat laporan sakit untuk {$santri->nama_lengkap}",
                    'ip_address' => $request->ip()
                ]);
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Laporan santri sakit berhasil dikirim.',
                    'redirect' => route('user.dashboard')
                ]);
            }
            return redirect()->route('user.dashboard')->with('success', 'Laporan santri sakit berhasil dikirim.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error submitting sakit form: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal mengirim laporan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal mengirim laporan: ' . $e->getMessage())->withInput();
        }
    }
}
