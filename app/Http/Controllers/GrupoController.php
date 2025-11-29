<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with(['clase', 'subgrupos'])->get();
        return response()->json($grupos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:10|unique:grupos,codigo',
            'nombre' => 'required|string',
            'clase_id' => 'required|exists:clases_cuenta,id',
        ]);

        $grupo = Grupo::create($request->all());
        return response()->json($grupo->load('clase'), 201);
    }

    public function show($id)
    {
        $grupo = Grupo::with(['clase', 'subgrupos'])->findOrFail($id);
        return response()->json($grupo);
    }

    public function update(Request $request, $id)
    {
        $grupo = Grupo::findOrFail($id);
        
        $request->validate([
            'codigo' => 'required|string|max:10|unique:grupos,codigo,' . $id,
            'nombre' => 'required|string',
            'clase_id' => 'required|exists:clases_cuenta,id',
        ]);

        $grupo->update($request->all());
        return response()->json($grupo->load('clase'));
    }

    public function destroy($id)
    {
        $grupo = Grupo::findOrFail($id);
        $grupo->delete();
        return response()->json(null, 204);
    }
}

