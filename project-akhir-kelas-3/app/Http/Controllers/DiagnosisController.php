<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Diagnosis::query();

        if ($request->has('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        $diagnoses = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('diagnosis.table', compact('diagnoses'));
        }

        return view('diagnosis.index', compact('diagnoses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:diagnoses,nama'
        ]);

        Diagnosis::create(['nama' => $request->nama]);

        return response()->json(['success' => true, 'message' => 'Diagnosis berhasil ditambahkan']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diagnosis $diagnosis)
    {
        $request->validate([
            'nama' => 'required|string|unique:diagnoses,nama,' . $diagnosis->id
        ]);

        $diagnosis->update(['nama' => $request->nama]);

        return response()->json(['success' => true, 'message' => 'Diagnosis berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diagnosis $diagnosis)
    {
        $diagnosis->delete();

        return response()->json(['success' => true, 'message' => 'Diagnosis berhasil dihapus']);
    }

    /**
     * Search for diagnoses (for tag input)
     */
    public function search(Request $request)
    {
        $q = $request->get('q');
        $diagnoses = Diagnosis::where('nama', 'like', "%$q%")
            ->limit(10)
            ->get();

        return response()->json($diagnoses);
    }
}
