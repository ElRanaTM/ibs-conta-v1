<?php

namespace App\Http\Controllers;

use App\Models\CuentaPrincipal;
use Illuminate\Http\Request;

class CuentaPrincipalController extends Controller
{
    public function index()
    {
        $cuentas = CuentaPrincipal::with(['subgrupo', 'cuentasAnaliticas'])->get();
        return response()->json($cuentas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:10|unique:cuentas_principales,codigo',
            'nombre' => 'required|string',
            'subgrupo_id' => 'required|exists:subgrupos,id',
        ]);

        $cuenta = CuentaPrincipal::create($request->all());
        return response()->json($cuenta->load('subgrupo'), 201);
    }

    public function show($id)
    {
        $cuenta = CuentaPrincipal::with(['subgrupo', 'cuentasAnaliticas'])->findOrFail($id);
        return response()->json($cuenta);
    }

    public function update(Request $request, $id)
    {
        $cuenta = CuentaPrincipal::findOrFail($id);
        
        $request->validate([
            'codigo' => 'required|string|max:10|unique:cuentas_principales,codigo,' . $id,
            'nombre' => 'required|string',
            'subgrupo_id' => 'required|exists:subgrupos,id',
        ]);

        $cuenta->update($request->all());
        return response()->json($cuenta->load('subgrupo'));
    }

    public function destroy($id)
    {
        $cuenta = CuentaPrincipal::findOrFail($id);
        $cuenta->delete();
        return response()->json(null, 204);
    }
}

