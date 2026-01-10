<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SakitSantri;
use App\Models\Santri;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SakitController extends Controller
{
    /**
     * Get list of sakit records with filters
     * 
     * GET /api/sakit
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = SakitSantri::with(['santri', 'obats', 'petugas']);

        // Filter by santri
        if ($request->has('santri_id')) {
            $query->where('santri_id', $request->santri_id);
        }

        // Filter by tingkat kondisi
        if ($request->has('tingkat_kondisi')) {
            $query->where('tingkat_kondisi', $request->tingkat_kondisi);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from_date')) {
            $query->whereDate('tanggal_mulai_sakit', '>=', $request->from_date);
        }
        if ($request->has('to_date')) {
            $query->whereDate('tanggal_mulai_sakit', '<=', $request->to_date);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'tanggal_mulai_sakit');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $records = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $records->items(),
            'meta' => [
                'current_page' => $records->currentPage(),
                'last_page' => $records->lastPage(),
                'per_page' => $records->perPage(),
                'total' => $records->total()
            ]
        ]);
    }

    /**
     * Get single sakit record
     * 
     * GET /api/sakit/{id}
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $sakit = SakitSantri::with(['santri.kelas', 'obats', 'petugas'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $sakit
        ]);
    }

    /**
     * Create new sakit record with obat pivot
     * 
     * POST /api/sakit
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal_mulai_sakit' => 'required|date',
            'diagnosis' => 'required|string|max:255',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'nullable|string',
            'suhu_tubuh' => 'nullable|numeric|min:35|max:42',
            'status' => 'required|in:sakit,sembuh,kontrol',
            'tingkat_kondisi' => 'required|in:ringan,sedang,berat',
            'tanggal_selesai_sakit' => 'nullable|date|after_or_equal:tanggal_mulai_sakit',
            'catatan' => 'nullable|string',
            'obat' => 'nullable|array',
            'obat.*.id' => 'required_with:obat|exists:obats,id',
            'obat.*.dosis' => 'nullable|string',
            'obat.*.jumlah' => 'nullable|integer|min:1',
            'obat.*.tujuan' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Get santri's current kelas for snapshot
            $santri = Santri::with('kelas')->find($request->santri_id);
            $kelasText = $santri->kelas ? $santri->kelas->nama_kelas : null;

            // Create sakit record
            $sakit = SakitSantri::create([
                'santri_id' => $request->santri_id,
                'user_id' => auth()->id(),
                'kelas_text' => $kelasText,
                'tanggal_mulai_sakit' => $request->tanggal_mulai_sakit,
                'tanggal_selesai_sakit' => $request->tanggal_selesai_sakit,
                'diagnosis' => $request->diagnosis,
                'gejala' => $request->gejala,
                'tindakan' => $request->tindakan,
                'resep_obat' => $request->resep_obat ?? '',
                'suhu_tubuh' => $request->suhu_tubuh,
                'status' => $request->status,
                'tingkat_kondisi' => $request->tingkat_kondisi,
                'catatan' => $request->catatan
            ]);

            // Attach obat if provided
            if ($request->has('obat') && is_array($request->obat)) {
                foreach ($request->obat as $obatData) {
                    $obat = Obat::find($obatData['id']);
                    $jumlah = $obatData['jumlah'] ?? 1;

                    // Reduce stock
                    if ($obat && $obat->stok >= $jumlah) {
                        $obat->reduceStock($jumlah);
                    }

                    $sakit->obats()->attach($obatData['id'], [
                        'jumlah' => $jumlah,
                        'dosis' => $obatData['dosis'] ?? null,
                        'tujuan' => $obatData['tujuan'] ?? null
                    ]);
                }
            }

            // Update santri status if currently sick
            if ($request->status === 'sakit') {
                $santri->update(['status_kesehatan' => 'sakit']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data sakit berhasil disimpan',
                'data' => $sakit->load(['santri', 'obats', 'petugas'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update sakit record
     * 
     * PUT /api/sakit/{id}
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $sakit = SakitSantri::findOrFail($id);

        $request->validate([
            'tanggal_mulai_sakit' => 'sometimes|date',
            'diagnosis' => 'sometimes|string|max:255',
            'gejala' => 'sometimes|string',
            'tindakan' => 'sometimes|string',
            'resep_obat' => 'nullable|string',
            'suhu_tubuh' => 'nullable|numeric|min:35|max:42',
            'status' => 'sometimes|in:sakit,sembuh,kontrol',
            'tingkat_kondisi' => 'sometimes|in:ringan,sedang,berat',
            'tanggal_selesai_sakit' => 'nullable|date',
            'catatan' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $sakit->status;
            $sakit->update($request->only([
                'tanggal_mulai_sakit',
                'tanggal_selesai_sakit',
                'diagnosis',
                'gejala',
                'tindakan',
                'resep_obat',
                'suhu_tubuh',
                'status',
                'tingkat_kondisi',
                'catatan'
            ]));

            // Update santri status if changed to sembuh
            if ($oldStatus !== 'sembuh' && $request->status === 'sembuh') {
                // Check if santri has other active sick records
                $hasOtherActive = SakitSantri::where('santri_id', $sakit->santri_id)
                    ->where('id', '!=', $sakit->id)
                    ->where('status', 'sakit')
                    ->exists();

                if (!$hasOtherActive) {
                    Santri::find($sakit->santri_id)->update(['status_kesehatan' => 'sehat']);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data sakit berhasil diperbarui',
                'data' => $sakit->fresh(['santri', 'obats', 'petugas'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete sakit record
     * 
     * DELETE /api/sakit/{id}
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $sakit = SakitSantri::findOrFail($id);

        DB::beginTransaction();
        try {
            // Restore obat stock
            foreach ($sakit->obats as $obat) {
                $obat->addStock($obat->pivot->jumlah);
            }

            // Detach obats
            $sakit->obats()->detach();

            // Delete record
            $sakit->delete();

            // Update santri status if no more active sick records
            $hasOtherActive = SakitSantri::where('santri_id', $sakit->santri_id)
                ->where('status', 'sakit')
                ->exists();

            if (!$hasOtherActive) {
                Santri::find($sakit->santri_id)->update(['status_kesehatan' => 'sehat']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data sakit berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark record as recovered
     * 
     * PUT /api/sakit/{id}/sembuh
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markRecovered($id)
    {
        $sakit = SakitSantri::findOrFail($id);

        $sakit->update([
            'status' => 'sembuh',
            'tanggal_selesai_sakit' => now()->toDateString()
        ]);

        // Check if santri has other active sick records
        $hasOtherActive = SakitSantri::where('santri_id', $sakit->santri_id)
            ->where('id', '!=', $sakit->id)
            ->where('status', 'sakit')
            ->exists();

        if (!$hasOtherActive) {
            Santri::find($sakit->santri_id)->update(['status_kesehatan' => 'sehat']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah menjadi sembuh',
            'data' => $sakit->fresh(['santri', 'obats'])
        ]);
    }
}
