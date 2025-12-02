<?php

namespace App\Http\Controllers;

use App\Models\TipoCambio;
use App\Models\Moneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TipoCambioController extends Controller
{
    public function index(Request $request)
    {
        $fecha = $request->get('fecha', date('Y-m-d'));
        $tiposCambio = TipoCambio::where('fecha', $fecha)
            ->with('moneda')
            ->get();
        
        return response()->json($tiposCambio);
    }

    public function store(Request $request, $id) // Agrega $id como parámetro
    {
        Log::info('Store TipoCambio called', ['request' => $request->all(), 'id' => $id]);
        
        // Usar $id de la ruta como id_moneda si no viene en el request
        $id_moneda = $request->input('id_moneda', $id);
        
        $request->validate([
            'fecha' => 'required|date',
            'valor' => 'required|numeric|min:0',
        ]);

        // Validar que la moneda existe
        $moneda = Moneda::find($id_moneda, ['id_moneda']);
        if (!$moneda) {
            Log::error('Moneda not found', ['id_moneda' => $id_moneda]);
            return back()->withErrors(['error' => 'Moneda no encontrada']);
        }

        Log::info('Moneda found', ['moneda' => $moneda]);

        // Si es moneda local, el valor debe ser 1
        if ($moneda->es_local && $request->valor != 1) {
            Log::warning('Moneda local error', ['valor' => $request->valor]);
            return back()->withErrors(['valor' => 'La moneda local siempre debe tener un tipo de cambio de 1.']);
        }

        try {
            $tipoCambio = TipoCambio::updateOrCreate(
                [
                    'id_moneda' => $id_moneda,
                    'fecha' => $request->fecha,
                ],
                [
                    'valor' => $request->valor,
                ]
            );
            
            Log::info('TipoCambio created/updated successfully', ['tipoCambio' => $tipoCambio]);
            
            return back()->with('success', 'Tipo de cambio registrado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error creating TipoCambio', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()]);
        }
    }
}  