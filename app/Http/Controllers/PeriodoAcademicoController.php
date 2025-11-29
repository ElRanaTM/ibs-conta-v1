<?php

namespace App\Http\Controllers;

use App\Models\PeriodoAcademico;
use Illuminate\Http\Request;

class PeriodoAcademicoController extends Controller
{
    public function index()
    {
        $periodos = PeriodoAcademico::all();
        return response()->json($periodos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_periodo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'activo' => 'boolean',
        ]);

        $periodo = PeriodoAcademico::create($request->all());
        return response()->json($periodo, 201);
    }

    public function show($id)
    {
        $periodo = PeriodoAcademico::findOrFail($id);
        return response()->json($periodo);
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
        return response()->json($periodo);
    }

    public function destroy($id)
    {
        $periodo = PeriodoAcademico::findOrFail($id);
        $periodo->delete();
        return response()->json(null, 204);
    }
}

