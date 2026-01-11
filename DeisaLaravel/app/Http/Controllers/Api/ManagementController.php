<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Diagnosis;
use App\Models\Santri;
use App\Models\Obat;
use Illuminate\Support\Str;

class ManagementController extends Controller
{
    private function getModel($type)
    {
        return match ($type) {
            'kelas' => Kelas::class,
            'jurusan' => Jurusan::class,
            'diagnosis' => Diagnosis::class,
            default => null,
        };
    }

    public function index($type)
    {
        $modelClass = $this->getModel($type);
        if (!$modelClass) return response()->json(['message' => 'Invalid type'], 400);

        $query = $modelClass::query();
        if ($type === 'kelas') $query->with('jurusan');

        return response()->json([
            'status' => 'success',
            'data' => $query->paginate(15)
        ]);
    }

    public function all($type)
    {
        $modelClass = $this->getModel($type);
        if (!$modelClass) return response()->json(['message' => 'Invalid type'], 400);

        return response()->json([
            'status' => 'success',
            'data' => $modelClass::all()
        ]);
    }

    public function store($type, Request $request)
    {
        $modelClass = $this->getModel($type);
        if (!$modelClass) return response()->json(['message' => 'Invalid type'], 400);

        $rules = match ($type) {
            'kelas' => ['nama_kelas' => 'required|string', 'jurusan_id' => 'required|exists:jurusans,id', 'tahun_ajaran' => 'required|string'],
            'jurusan' => ['nama_jurusan' => 'required|string', 'kode_jurusan' => 'required|string|unique:jurusans,kode_jurusan'],
            'diagnosis' => ['nama_diagnosis' => 'required|string', 'kategori' => 'required|in:Ringan,Sedang,Berat'],
            default => [],
        };

        $request->validate($rules);
        $item = $modelClass::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => ucfirst($type) . ' created successfully',
            'data' => $item
        ], 201);
    }

    public function destroy($type, $id)
    {
        $modelClass = $this->getModel($type);
        if (!$modelClass) return response()->json(['message' => 'Invalid type'], 400);

        $item = $modelClass::findOrFail($id);
        $item->delete();

        return response()->json(['status' => 'success', 'message' => ucfirst($type) . ' deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = $request->query('q');
        if (!$query) return response()->json(['data' => []]);

        $santri = Santri::where('nama_lengkap', 'LIKE', "%{$query}%")->orWhere('nis', 'LIKE', "%{$query}%")->limit(5)->get()->map(fn($item) => [...$item->toArray(), 'type' => 'santri']);
        $obat = Obat::where('nama_obat', 'LIKE', "%{$query}%")->limit(5)->get()->map(fn($item) => [...$item->toArray(), 'type' => 'obat']);
        
        return response()->json([
            'status' => 'success',
            'data' => $santri->concat($obat)
        ]);
    }
}
