<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
            'nombres' => 'required|string',
            'apellido_paterno' => 'nullable|string',
            'apellido_materno' => 'nullable|string',
            'ci' => 'nullable|string',
            'celular' => 'nullable|string',
            'direccion' => 'nullable|string',
            'observacion' => 'nullable|string',
            'estado' => 'in:activo,inactivo',
        ]);

        // Generar código automático
        $initialsParts = array_filter(preg_split('/\s+/', ($request->nombres . ' ' . $request->apellido_paterno . ' ' . $request->apellido_materno)));
        $initials = '';
        foreach ($initialsParts as $part) {
            $initials .= mb_substr($part, 0, 1);
        }
        $initials = strtoupper(preg_replace('/[^A-Z0-9]/', '', $initials));

        $ultimo = Alumno::latest('id_alumno')->first();
        $ultimoNumero = $ultimo ? (int) preg_replace('/[^0-9]/', '', $ultimo->codigo) : 0;
        $nuevoNumero = $ultimoNumero + 1;
        $codigo = $initials . '-' . str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT);

        $data = $request->only(['nombres', 'apellido_paterno', 'apellido_materno', 'ci', 'celular', 'direccion', 'observacion', 'estado']);
        $data['codigo'] = $codigo;

        $alumno = Alumno::create($data);
        
        if ($request->has('apoderados')) {
            $alumno->apoderados()->sync($request->apoderados);
        }

        // Mantener campo legacy 'nombre_completo' si existe
        if (Schema::hasColumn('alumno', 'nombre_completo')) {
            $alumno->nombre_completo = trim(($alumno->nombres ?? '') . ' ' . ($alumno->apellido_paterno ?? '') . ' ' . ($alumno->apellido_materno ?? ''));
            $alumno->save();
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
            'nombres' => 'required|string',
            'apellido_paterno' => 'nullable|string',
            'apellido_materno' => 'nullable|string',
            'ci' => 'nullable|string',
            'celular' => 'nullable|string',
            'direccion' => 'nullable|string',
            'observacion' => 'nullable|string',
            'estado' => 'in:activo,inactivo',
        ]);

        $alumno->update($request->only(['nombres', 'apellido_paterno', 'apellido_materno', 'ci', 'celular', 'direccion', 'observacion', 'estado']));
        
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

