<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::with('apoderados')->get();
        return response()->json($alumnos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|unique:alumno,codigo',
            'nombre_completo' => 'required|string',
            'ci' => 'nullable|string',
            'celular' => 'nullable|string',
            'direccion' => 'nullable|string',
            'observacion' => 'nullable|string',
            'estado' => 'in:activo,inactivo',
        ]);

        $alumno = Alumno::create($request->all());
        
        if ($request->has('apoderados')) {
            $alumno->apoderados()->sync($request->apoderados);
        }

        return response()->json($alumno->load('apoderados'), 201);
    }

    public function show($id)
    {
        $alumno = Alumno::with('apoderados', 'pagos')->findOrFail($id);
        return response()->json($alumno);
    }

    public function update(Request $request, $id)
    {
        $alumno = Alumno::findOrFail($id);
        
        $request->validate([
            'codigo' => 'required|string|unique:alumno,codigo,' . $id . ',id_alumno',
            'nombre_completo' => 'required|string',
            'ci' => 'nullable|string',
            'celular' => 'nullable|string',
            'direccion' => 'nullable|string',
            'observacion' => 'nullable|string',
            'estado' => 'in:activo,inactivo',
        ]);

        $alumno->update($request->all());
        
        if ($request->has('apoderados')) {
            $alumno->apoderados()->sync($request->apoderados);
        }

        return response()->json($alumno->load('apoderados'));
    }

    public function destroy($id)
    {
        $alumno = Alumno::findOrFail($id);
        $alumno->delete();
        return response()->json(null, 204);
    }
}

