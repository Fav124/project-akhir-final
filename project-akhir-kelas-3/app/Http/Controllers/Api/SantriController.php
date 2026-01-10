<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    /**
     * Get list of santri with pagination and filters
     * 
     * GET /api/santri
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Santri::with(['kelas', 'jurusan']);

        // Filter by kelas
        if ($request->has('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter by jurusan
        if ($request->has('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by status kesehatan
        if ($request->has('status_kesehatan')) {
            $query->where('status_kesehatan', $request->status_kesehatan);
        }

        // Search by name or NIS
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'nama_lengkap');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $santris = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $santris->items(),
            'meta' => [
                'current_page' => $santris->currentPage(),
                'last_page' => $santris->lastPage(),
                'per_page' => $santris->perPage(),
                'total' => $santris->total()
            ]
        ]);
    }

    /**
     * Get santri detail with sick history
     * 
     * GET /api/santri/{id}
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $santri = Santri::with(['kelas.jurusan', 'jurusan', 'sakitSantris.obats', 'wali'])
            ->findOrFail($id);

        // Get sick statistics
        $sickCount = $santri->sakitSantris()->count();
        $currentlySick = $santri->sakitSantris()->where('status', 'sakit')->exists();

        return response()->json([
            'success' => true,
            'data' => [
                'santri' => $santri,
                'statistics' => [
                    'total_sick_records' => $sickCount,
                    'currently_sick' => $currentlySick
                ],
                'recent_sick_records' => $santri->sakitSantris()
                    ->with('obats')
                    ->orderBy('tanggal_mulai_sakit', 'desc')
                    ->limit(5)
                    ->get()
            ]
        ]);
    }

    /**
     * Search santri (for autocomplete/typeahead)
     * 
     * GET /api/santri/search
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $search = $request->get('q', '');
        
        if (strlen($search) < 2) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        $santris = Santri::with('kelas')
            ->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get(['id', 'nis', 'nama_lengkap', 'kelas_id', 'foto', 'status_kesehatan']);

        return response()->json([
            'success' => true,
            'data' => $santris
        ]);
    }
}
