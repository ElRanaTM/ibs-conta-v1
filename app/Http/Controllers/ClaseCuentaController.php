<?php

namespace App\Http\Controllers;

use App\Models\ClaseCuenta;
use Illuminate\Http\Request;

class ClaseCuentaController extends Controller
{
    public function index()
    {
        $clases = ClaseCuenta::with('grupos')->get();
        return response()->json($clases);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:10|unique:clases_cuenta,codigo',
            'nombre' => 'required|string',
        ]);

        $clase = ClaseCuenta::create($request->all());
        return response()->json($clase, 201);
    }

    public function show($id)
    {
        $clase = ClaseCuenta::with('grupos')->findOrFail($id);
        return response()->json($clase);
    }

    public function update(Request $request, $id)
    {
        $clase = ClaseCuenta::findOrFail($id);
        
        $request->validate([
            'codigo' => 'required|string|max:10|unique:clases_cuenta,codigo,' . $id,
            'nombre' => 'required|string',
        ]);

        $clase->update($request->all());
        return response()->json($clase);
    }

    public function destroy($id)
    {
        $clase = ClaseCuenta::findOrFail($id);
        $clase->delete();
        return response()->json(null, 204);
    }
}

