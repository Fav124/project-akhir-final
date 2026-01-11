<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Diagnosis;

class MasterDataController extends Controller
{
    // --- JURUSAN ---
    public function getJurusan()
    {
        return response()->json(['data' => Jurusan::all()]);
    }
    
    public function storeJurusan(Request $request)
    {
        $request->validate(['nama_jurusan' => 'required|unique:jurusans']);
        $jurusan = Jurusan::create($request->all());
        return response()->json(['data' => $jurusan], 201);
    }
    
    public function destroyJurusan($id) {
        Jurusan::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // --- KELAS ---
    public function getKelas()
    {
        return response()->json(['data' => Kelas::with('jurusan')->get()]);
    }
    
    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);
        $kelas = Kelas::create($request->all());
        return response()->json(['data' => $kelas], 201);
    }
    
    public function destroyKelas($id) {
        Kelas::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // --- DIAGNOSIS ---
    public function getDiagnosis()
    {
        return response()->json(['data' => Diagnosis::all()]);
    }
    
    public function storeDiagnosis(Request $request)
    {
        $request->validate(['nama_diagnosis' => 'required']);
        $diagnosis = Diagnosis::create($request->all());
        return response()->json(['data' => $diagnosis], 201);
    }
    
     public function destroyDiagnosis($id) {
        Diagnosis::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
