<?php

namespace App\Http\Controllers;

use App\Models\CuentaAnalitica;
use Illuminate\Http\Request;

class CuentaAnaliticaController extends Controller
{
    public function index()
    {
        $cuentas = CuentaAnalitica::with('cuentaPrincipal')->get();
        return response()->json($cuentas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:20|unique:cuentas_analiticas,codigo',
            'nombre' => 'required|string',
            'cuenta_principal_id' => 'required|exists:cuentas_principales,id',
            'es_auxiliar' => 'boolean',
        ]);

        $cuenta = CuentaAnalitica::create($request->all());
        return response()->json($cuenta->load('cuentaPrincipal'), 201);
    }

    public function show($id)
    {
        $cuenta = CuentaAnalitica::with('cuentaPrincipal')->findOrFail($id);
        return response()->json($cuenta);
    }

    public function update(Request $request, $id)
    {
        $cuenta = CuentaAnalitica::findOrFail($id);
        
        $request->validate([
            'codigo' => 'required|string|max:20|unique:cuentas_analiticas,codigo,' . $id,
            'nombre' => 'required|string',
            'cuenta_principal_id' => 'required|exists:cuentas_principales,id',
            'es_auxiliar' => 'boolean',
        ]);

        $cuenta->update($request->all());
        return response()->json($cuenta->load('cuentaPrincipal'));
    }

    public function destroy($id)
    {
        $cuenta = CuentaAnalitica::findOrFail($id);
        $cuenta->delete();
        return response()->json(null, 204);
    }
}

