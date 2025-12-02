<?php

namespace App\Http\Controllers;

use App\Models\ConceptoIngreso;
use Illuminate\Http\Request;

class ConceptoIngresoController extends Controller
{
    public function index()
    {
        $conceptos = ConceptoIngreso::all();
        return view('catalogos.conceptos_ingreso.index', compact('conceptos'));
    }

    public function create()
    {
        return view('catalogos.conceptos_ingreso.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'monto_base' => 'required|numeric|min:0',
        ]);

        ConceptoIngreso::create($request->all());
        return redirect()->route('catalogos.conceptos-ingreso.index')->with('success', 'Concepto de ingreso creado exitosamente.');
    }

    public function show($id)
    {
        $concepto = ConceptoIngreso::findOrFail($id);
        return response()->json($concepto);
    }

    public function edit($id)
    {
        $concepto = ConceptoIngreso::findOrFail($id);
        return view('catalogos.conceptos_ingreso.edit', compact('concepto'));
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
        return redirect()->route('catalogos.conceptos-ingreso.index')->with('success', 'Concepto de ingreso actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $concepto = ConceptoIngreso::findOrFail($id);
        $concepto->delete();
        return redirect()->route('catalogos.conceptos-ingreso.index')->with('success', 'Concepto de ingreso eliminado exitosamente.');
    }
}

