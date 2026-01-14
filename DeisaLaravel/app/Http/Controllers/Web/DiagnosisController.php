<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diagnosis;

class DiagnosisController extends Controller
{
    public function index()
    {
        $diagnoses = Diagnosis::paginate(15);
        return view('diagnosis.index', compact('diagnoses'));
    }

    public function create()
    {
        return view('diagnosis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_diagnosis' => 'required',
            'kategori' => 'required|in:Ringan,Sedang,Berat',
        ]);

        Diagnosis::create($request->all());

        return redirect()->route('web.diagnosis.index')->with('success', 'Diagnosis created successfully.');
    }

    public function edit(Diagnosis $diagnosis)
    {
        return view('diagnosis.edit', compact('diagnosis'));
    }

    public function update(Request $request, Diagnosis $diagnosis)
    {
        $request->validate([
            'nama_diagnosis' => 'required',
            'kategori' => 'required|in:Ringan,Sedang,Berat',
        ]);

        $diagnosis->update($request->all());

        return redirect()->route('web.diagnosis.index')->with('success', 'Diagnosis updated successfully.');
    }

    public function destroy(Diagnosis $diagnosis)
    {
        $diagnosis->delete();
        return redirect()->route('web.diagnosis.index')->with('success', 'Diagnosis deleted successfully.');
    }
}
