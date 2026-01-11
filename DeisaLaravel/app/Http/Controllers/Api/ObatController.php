<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Obat::all()]);
    }

    public function store(Request $request)
    {
        $request->validate(['nama_obat' => 'required']);
        $obat = Obat::create($request->all());
        return response()->json(['data' => $obat], 201);
    }

    public function update(Request $request, $id)
    {
        $obat = Obat::find($id);
        if (!$obat) return response()->json(['message' => 'Not Found'], 404);
        $obat->update($request->all());
        return response()->json(['data' => $obat]);
    }

    public function destroy($id)
    {
        Obat::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
