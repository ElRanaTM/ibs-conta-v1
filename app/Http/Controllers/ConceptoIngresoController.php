<?php

namespace App\Http\Controllers;

use App\Models\ConceptoIngreso;
use Illuminate\Http\Request;

class ConceptoIngresoController extends Controller
{
    public function index()
    {
        $conceptos = ConceptoIngreso::all();
        return response()->json($conceptos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'monto_base' => 'required|numeric|min:0',
        ]);

        $concepto = ConceptoIngreso::create($request->all());
        return response()->json($concepto, 201);
    }

    public function show($id)
    {
        $concepto = ConceptoIngreso::findOrFail($id);
        return response()->json($concepto);
    }

    public function update(Request $request, $id)
    {
        $concepto = ConceptoIngreso::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'monto_base' => 'required|numeric|min:0',
        ]);

        $concepto->update($request->all());
        return response()->json($concepto);
    }

    public function destroy($id)
    {
        $concepto = ConceptoIngreso::findOrFail($id);
        $concepto->delete();
        return response()->json(null, 204);
    }
}

