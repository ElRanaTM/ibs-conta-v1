<?php

namespace App\Http\Controllers;

use App\Models\Asiento;
use App\Services\NumeracionService;
use Illuminate\Http\Request;

class AsientoController extends Controller
{
    public function index()
    {
        $asientos = Asiento::with(['usuario', 'detalleAsientos'])->get();
        return response()->json($asientos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'glosa' => 'required|string',
            'estado' => 'boolean',
            'usuario_id' => 'required|exists:users,id',
            'detalle_asientos' => 'required|array|min:1',
            'detalle_asientos.*.cuenta_analitica_id' => 'required|exists:cuentas_analiticas,id',
            'detalle_asientos.*.debe' => 'required|numeric|min:0',
            'detalle_asientos.*.haber' => 'required|numeric|min:0',
        ]);

        $numeroAsiento = NumeracionService::generarNumero('asiento', 'ASI');
        
        $asiento = Asiento::create([
            'fecha' => $request->fecha,
            'glosa' => $request->glosa,
            'estado' => $request->estado ?? true,
            'usuario_id' => $request->usuario_id,
            'numero_asiento' => $numeroAsiento,
            'serie' => 'ASI',
        ]);

        foreach ($request->detalle_asientos as $detalle) {
            $asiento->detalleAsientos()->create($detalle);
        }

        return response()->json($asiento->load(['usuario', 'detalleAsientos']), 201);
    }

    public function show($id)
    {
        $asiento = Asiento::with(['usuario', 'detalleAsientos.cuentaAnalitica', 'detalleAsientos.metodoPago'])->findOrFail($id);
        return response()->json($asiento);
    }

    public function update(Request $request, $id)
    {
        $asiento = Asiento::findOrFail($id);
        
        $request->validate([
            'fecha' => 'required|date',
            'glosa' => 'required|string',
            'estado' => 'boolean',
            'detalle_asientos' => 'array|min:1',
        ]);

        $asiento->update($request->only(['fecha', 'glosa', 'estado']));

        if ($request->has('detalle_asientos')) {
            $asiento->detalleAsientos()->delete();
            foreach ($request->detalle_asientos as $detalle) {
                $asiento->detalleAsientos()->create($detalle);
            }
        }

        return response()->json($asiento->load(['usuario', 'detalleAsientos']));
    }

    public function destroy($id)
    {
        $asiento = Asiento::findOrFail($id);
        $asiento->delete();
        return response()->json(null, 204);
    }
}

