<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::with('apoderados')->latest()->paginate(15);
        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $apoderados = \App\Models\Apoderado::all();
        return view('alumnos.create', compact('apoderados'));
    }

    public function edit($id)
    {
        $alumno = Alumno::with('apoderados')->findOrFail($id);
        $apoderados = \App\Models\Apoderado::all();
        return view('alumnos.edit', compact('alumno', 'apoderados'));
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

        return redirect()->route('alumnos.index')->with('success', 'Alumno creado exitosamente.');
    }

    public function show($id)
    {
        $alumno = Alumno::with('apoderados', 'pagos.concepto', 'pagos.periodo', 'pagos.moneda')->findOrFail($id);
        return view('alumnos.show', compact('alumno'));
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

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $alumno = Alumno::findOrFail($id);
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado exitosamente.');
    }
}

