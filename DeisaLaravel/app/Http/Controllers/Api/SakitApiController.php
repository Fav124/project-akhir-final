<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SantriSakit;
use App\Models\Activity;
use Illuminate\Http\Request;

class SakitApiController extends Controller
{
    /**
     * Display a listing of sakit records
     */
    public function index(Request $request)
    {
        $query = SantriSakit::with(['santri.kelas']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search by santri name
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('santri', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 20);
        $sakit = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $sakit->map(function ($s) {
            return [
                    'id' => $s->id,
                    'santri' => [
                        'id' => $s->santri->id,
                        'nama' => $s->santri->nama_lengkap,
                        'kelas' => $s->santri->kelas->nama_kelas ?? '-'
                    ],
                    'diagnosis_utama' => $s->diagnosis_utama,
                    'keluhan' => $s->keluhan,
                    'tindakan' => $s->tindakan,
                    'status' => $s->status,
                    'tanggal_masuk' => $s->created_at->format('Y-m-d H:i'),
                    'tanggal_masuk_human' => $s->created_at->diffForHumans()
                ];
        }),
            'meta' => [
                'current_page' => $sakit->currentPage(),
                'last_page' => $sakit->lastPage(),
                'per_page' => $sakit->perPage(),
                'total' => $sakit->total()
            ]
        ]);
    }

    /**
     * Store a newly created sakit record (Admin & Staff)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'diagnosis_utama' => 'required|string',
            'keluhan' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'status' => 'required|in:Sakit,Sembuh'
        ]);

        $sakit = SantriSakit::create($validated);

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'create_sakit',
            'description' => "Menambah data sakit: {$sakit->santri->nama_lengkap}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data sakit berhasil ditambahkan',
            'data' => $sakit->load('santri.kelas')
        ], 201);
    }

    /**
     * Display the specified sakit record
     */
    public function show($id)
    {
        $sakit = SantriSakit::with(['santri.kelas'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $sakit->id,
                'santri' => [
                    'id' => $sakit->santri->id,
                    'nama' => $sakit->santri->nama_lengkap,
                    'kelas' => $sakit->santri->kelas->nama_kelas ?? '-'
                ],
                'diagnosis_utama' => $sakit->diagnosis_utama,
                'keluhan' => $sakit->keluhan,
                'tindakan' => $sakit->tindakan,
                'status' => $sakit->status,
                'created_at' => $sakit->created_at->format('Y-m-d H:i'),
                'updated_at' => $sakit->updated_at->format('Y-m-d H:i')
            ]
        ]);
    }

    /**
     * Update the specified sakit record (Admin & Staff)
     */
    public function update(Request $request, $id)
    {
        $sakit = SantriSakit::findOrFail($id);

        $validated = $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'diagnosis_utama' => 'required|string',
            'keluhan' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'status' => 'required|in:Sakit,Sembuh'
        ]);

        $sakit->update($validated);

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'update_sakit',
            'description' => "Mengupdate data sakit: {$sakit->santri->nama_lengkap}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data sakit berhasil diupdate',
            'data' => $sakit->load('santri.kelas')
        ]);
    }

    /**
     * Remove the specified sakit record (Admin only)
     */
    public function destroy(Request $request, $id)
    {
        // Check if user is admin
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin only.'
            ], 403);
        }

        $sakit = SantriSakit::findOrFail($id);
        $santriNama = $sakit->santri->nama_lengkap;
        $sakit->delete();

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'delete_sakit',
            'description' => "Menghapus data sakit: {$santriNama}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data sakit berhasil dihapus'
        ]);
    }
}