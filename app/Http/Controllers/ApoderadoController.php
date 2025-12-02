<?php

namespace App\Http\Controllers;

use App\Models\Apoderado;
use Illuminate\Http\Request;

class ApoderadoController extends Controller
{
    public function index()
    {
        $apoderados = Apoderado::with('alumnos')->latest()->paginate(15);
        return view('apoderados.index', compact('apoderados'));
    }

    public function create()
    {
        $alumnos = \App\Models\Alumno::all();
        return view('apoderados.create', compact('alumnos'));
    }

    public function edit($id)
    {
        $apoderado = Apoderado::with('alumnos')->findOrFail($id);
        $alumnos = \App\Models\Alumno::all();
        return view('apoderados.edit', compact('apoderado', 'alumnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string',
            'ci' => 'required|string',
            'celular' => 'nullable|string',
            'direccion' => 'nullable|string',
            'relacion_legal' => 'required|string',
            'observacion' => 'nullable|string',
        ]);

        $apoderado = Apoderado::create($request->all());
        
        if ($request->has('alumnos')) {
            $apoderado->alumnos()->sync($request->alumnos);
        }

        return redirect()->route('apoderados.index')->with('success', 'Apoderado creado exitosamente.');
    }

    public function show($id)
    {
        $apoderado = Apoderado::with('alumnos')->findOrFail($id);
        return view('apoderados.show', compact('apoderado'));
    }

    public function update(Request $request, $id)
    {
        $apoderado = Apoderado::findOrFail($id);
        
        $request->validate([
            'nombre_completo' => 'required|string',
            'ci' => 'required|string',
            'celular' => 'nullable|string',
            'direccion' => 'nullable|string',
            'relacion_legal' => 'required|string',
            'observacion' => 'nullable|string',
        ]);

        $apoderado->update($request->all());
        
        if ($request->has('alumnos')) {
            $apoderado->alumnos()->sync($request->alumnos);
        }

        return redirect()->route('apoderados.index')->with('success', 'Apoderado actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $apoderado = Apoderado::findOrFail($id);
        $apoderado->delete();
        return redirect()->route('apoderados.index')->with('success', 'Apoderado eliminado exitosamente.');
    }
}

