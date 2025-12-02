<?php

namespace App\Http\Controllers;

use App\Models\PeriodoAcademico;
use Illuminate\Http\Request;

class PeriodoAcademicoController extends Controller
{
    public function index()
    {
        $periodos = PeriodoAcademico::all();
        return view('catalogos.periodos_academicos.index', compact('periodos'));
    }

    public function create()
    {
        return view('catalogos.periodos_academicos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_periodo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'activo' => 'boolean',
        ]);

        PeriodoAcademico::create($request->all());
        return redirect()->route('catalogos.periodos-academicos.index')->with('success', 'Período académico creado exitosamente.');
    }

    public function show($id)
    {
        $periodo = PeriodoAcademico::findOrFail($id);
        return response()->json($periodo);
    }

    public function edit($id)
    {
        $periodo = PeriodoAcademico::findOrFail($id);
        return view('catalogos.periodos_academicos.edit', compact('periodo'));
    }

    public function update(Request $request, $id)
    {
        $periodo = PeriodoAcademico::findOrFail($id);
        
        $request->validate([
            'nombre_periodo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'activo' => 'boolean',
        ]);

        $periodo->update($request->all());
        return redirect()->route('catalogos.periodos-academicos.index')->with('success', 'Período académico actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $periodo = PeriodoAcademico::findOrFail($id);
        $periodo->delete();
        return redirect()->route('catalogos.periodos-academicos.index')->with('success', 'Período académico eliminado exitosamente.');
    }
}

