<?php

namespace App\Http\Controllers;

use App\Models\Subgrupo;
use Illuminate\Http\Request;

class SubgrupoController extends Controller
{
    public function index()
    {
        $subgrupos = Subgrupo::with(['grupo', 'cuentasPrincipales'])->get();
        return response()->json($subgrupos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:10|unique:subgrupos,codigo',
            'nombre' => 'required|string',
            'grupo_id' => 'required|exists:grupos,id',
        ]);

        $subgrupo = Subgrupo::create($request->all());
        return response()->json($subgrupo->load('grupo'), 201);
    }

    public function show($id)
    {
        $subgrupo = Subgrupo::with(['grupo', 'cuentasPrincipales'])->findOrFail($id);
        return response()->json($subgrupo);
    }

    public function update(Request $request, $id)
    {
        $subgrupo = Subgrupo::findOrFail($id);
        
        $request->validate([
            'codigo' => 'required|string|max:10|unique:subgrupos,codigo,' . $id,
            'nombre' => 'required|string',
            'grupo_id' => 'required|exists:grupos,id',
        ]);

        $subgrupo->update($request->all());
        return response()->json($subgrupo->load('grupo'));
    }

    public function destroy($id)
    {
        $subgrupo = Subgrupo::findOrFail($id);
        $subgrupo->delete();
        return response()->json(null, 204);
    }
}

