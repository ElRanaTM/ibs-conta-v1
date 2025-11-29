<?php

namespace App\Http\Controllers;

use App\Models\TipoCambio;
use Illuminate\Http\Request;

class TipoCambioController extends Controller
{
    public function index()
    {
        $tiposCambio = TipoCambio::with('moneda')->get();
        return response()->json($tiposCambio);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_moneda' => 'required|exists:moneda,id_moneda',
            'fecha' => 'required|date',
            'valor' => 'required|numeric|min:0',
        ]);

        $tipoCambio = TipoCambio::create($request->all());
        return response()->json($tipoCambio->load('moneda'), 201);
    }

    public function show($id)
    {
        $tipoCambio = TipoCambio::with('moneda')->findOrFail($id);
        return response()->json($tipoCambio);
    }

    public function update(Request $request, $id)
    {
        $tipoCambio = TipoCambio::findOrFail($id);
        
        $request->validate([
            'id_moneda' => 'required|exists:moneda,id_moneda',
            'fecha' => 'required|date',
            'valor' => 'required|numeric|min:0',
        ]);

        $tipoCambio->update($request->all());
        return response()->json($tipoCambio->load('moneda'));
    }

    public function destroy($id)
    {
        $tipoCambio = TipoCambio::findOrFail($id);
        $tipoCambio->delete();
        return response()->json(null, 204);
    }
}

