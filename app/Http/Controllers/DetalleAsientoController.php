<?php

namespace App\Http\Controllers;

use App\Models\DetalleAsiento;
use Illuminate\Http\Request;

class DetalleAsientoController extends Controller
{
    public function index()
    {
        $detalles = DetalleAsiento::with(['asiento', 'cuentaAnalitica', 'metodoPago'])->get();
        return response()->json($detalles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'asiento_id' => 'required|exists:asientos,id',
            'cuenta_analitica_id' => 'required|exists:cuentas_analiticas,id',
            'debe' => 'required|numeric|min:0',
            'haber' => 'required|numeric|min:0',
            'metodo_pago_id' => 'nullable|exists:metodo_pago,id',
        ]);

        $detalle = DetalleAsiento::create($request->all());
        return response()->json($detalle->load(['asiento', 'cuentaAnalitica', 'metodoPago']), 201);
    }

    public function show($id)
    {
        $detalle = DetalleAsiento::with(['asiento', 'cuentaAnalitica', 'metodoPago'])->findOrFail($id);
        return response()->json($detalle);
    }

    public function update(Request $request, $id)
    {
        $detalle = DetalleAsiento::findOrFail($id);
        
        $request->validate([
            'asiento_id' => 'required|exists:asientos,id',
            'cuenta_analitica_id' => 'required|exists:cuentas_analiticas,id',
            'debe' => 'required|numeric|min:0',
            'haber' => 'required|numeric|min:0',
            'metodo_pago_id' => 'nullable|exists:metodo_pago,id',
        ]);

        $detalle->update($request->all());
        return response()->json($detalle->load(['asiento', 'cuentaAnalitica', 'metodoPago']));
    }

    public function destroy($id)
    {
        $detalle = DetalleAsiento::findOrFail($id);
        $detalle->delete();
        return response()->json(null, 204);
    }
}

