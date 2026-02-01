<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Activity;
use Illuminate\Http\Request;

class SantriApiController extends Controller
{
    /**
     * Display a listing of santri
     */
    public function index(Request $request)
    {
        $query = Santri::with(['kelas', 'jurusan']);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Filter by kelas
        if ($request->has('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter by jurusan
        if ($request->has('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        $perPage = $request->get('per_page', 20);
        $santri = $query->orderBy('nama_lengkap')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $santri->map(function ($s) {
                return [
                    'id' => $s->id,
                    'nis' => $s->nis,
                    'nama_lengkap' => $s->nama_lengkap,
                    'jenis_kelamin' => $s->jenis_kelamin,
                    'tanggal_lahir' => $s->tanggal_lahir,
                    'alamat' => $s->alamat,
                    'kelas' => $s->kelas ? [
                        'id' => $s->kelas->id,
                        'nama' => $s->kelas->nama_kelas
                    ] : null,
                    'jurusan' => $s->jurusan ? [
                        'id' => $s->jurusan->id,
                        'nama' => $s->jurusan->nama_jurusan
                    ] : null
                ];
            }),
            'meta' => [
                'current_page' => $santri->currentPage(),
                'last_page' => $santri->lastPage(),
                'per_page' => $santri->perPage(),
                'total' => $santri->total()
            ]
        ]);
    }

    /**
     * Store a newly created santri (Admin only)
     */
    public function store(Request $request)
    {
        // Check if user is admin
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin only.'
            ], 403);
        }

        $validated = $request->validate([
            'nis' => 'required|string|unique:santri,nis',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusan,id'
        ]);

        $santri = Santri::create($validated);

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'create_santri',
            'description' => "Menambah santri: {$santri->nama_lengkap}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Santri berhasil ditambahkan',
            'data' => $santri->load(['kelas', 'jurusan'])
        ], 201);
    }

    /**
     * Display the specified santri
     */
    public function show($id)
    {
        $santri = Santri::with(['kelas', 'jurusan'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $santri->id,
                'nis' => $santri->nis,
                'nama_lengkap' => $santri->nama_lengkap,
                'jenis_kelamin' => $santri->jenis_kelamin,
                'tanggal_lahir' => $santri->tanggal_lahir,
                'alamat' => $santri->alamat,
                'kelas' => $santri->kelas ? [
                    'id' => $santri->kelas->id,
                    'nama' => $santri->kelas->nama_kelas
                ] : null,
                'jurusan' => $santri->jurusan ? [
                    'id' => $santri->jurusan->id,
                    'nama' => $santri->jurusan->nama_jurusan
                ] : null
            ]
        ]);
    }

    /**
     * Update the specified santri (Admin only)
     */
    public function update(Request $request, $id)
    {
        // Check if user is admin
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin only.'
            ], 403);
        }

        $santri = Santri::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|string|unique:santri,nis,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusan,id'
        ]);

        $santri->update($validated);

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'update_santri',
            'description' => "Mengupdate santri: {$santri->nama_lengkap}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Santri berhasil diupdate',
            'data' => $santri->load(['kelas', 'jurusan'])
        ]);
    }

    /**
     * Remove the specified santri (Admin only)
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

        $santri = Santri::findOrFail($id);
        $namaLengkap = $santri->nama_lengkap;
        $santri->delete();

        // Log activity
        Activity::create([
            'user_id' => $request->user()->id,
            'action' => 'delete_santri',
            'description' => "Menghapus santri: {$namaLengkap}"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Santri berhasil dihapus'
        ]);
    }
}
