<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\NumeracionDocumentos;
use App\Services\NumeracionService;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with(['alumno', 'concepto', 'periodo', 'moneda', 'metodoPago', 'asiento'])->get();
        return response()->json($pagos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_alumno' => 'required|exists:alumno,id_alumno',
            'id_concepto' => 'required|exists:concepto_ingreso,id_concepto',
            'fecha_pago' => 'required|date',
            'id_periodo' => 'required|exists:periodo_academico,id_periodo',
            'monto' => 'required|numeric|min:0',
            'id_moneda' => 'required|exists:moneda,id_moneda',
            'id_metodo_pago' => 'required|exists:metodo_pago,id',
            'referencia_pago' => 'nullable|string',
            'estado_pago' => 'in:pagado,pendiente,anulado',
            'id_asiento' => 'nullable|exists:asientos,id',
        ]);

        // Generar número de comprobante usando el servicio
        $numeroComprobante = NumeracionService::generarNumero('pago', 'PAG');
        
        // Obtener la numeración para el id_numeracion_documento
        $numeracion = NumeracionDocumentos::where('tipo_documento', 'pago')
            ->where('serie', 'PAG')
            ->where('activo', true)
            ->firstOrFail();

        $pago = Pago::create([
            'id_alumno' => $request->id_alumno,
            'id_concepto' => $request->id_concepto,
            'fecha_pago' => $request->fecha_pago,
            'id_periodo' => $request->id_periodo,
            'monto' => $request->monto,
            'id_moneda' => $request->id_moneda,
            'id_metodo_pago' => $request->id_metodo_pago,
            'referencia_pago' => $request->referencia_pago,
            'estado_pago' => $request->estado_pago ?? 'pagado',
            'id_asiento' => $request->id_asiento,
            'numero_comprobante' => $numeroComprobante,
            'serie' => 'PAG',
            'id_numeracion_documento' => $numeracion->id,
        ]);

        return response()->json($pago->load(['alumno', 'concepto', 'periodo', 'moneda', 'metodoPago', 'asiento']), 201);
    }

    public function show($id)
    {
        $pago = Pago::with(['alumno', 'concepto', 'periodo', 'moneda', 'metodoPago', 'asiento'])->findOrFail($id);
        return response()->json($pago);
    }

    public function update(Request $request, $id)
    {
        $pago = Pago::findOrFail($id);
        
        $request->validate([
            'id_alumno' => 'required|exists:alumno,id_alumno',
            'id_concepto' => 'required|exists:concepto_ingreso,id_concepto',
            'fecha_pago' => 'required|date',
            'id_periodo' => 'required|exists:periodo_academico,id_periodo',
            'monto' => 'required|numeric|min:0',
            'id_moneda' => 'required|exists:moneda,id_moneda',
            'id_metodo_pago' => 'required|exists:metodo_pago,id',
            'referencia_pago' => 'nullable|string',
            'estado_pago' => 'in:pagado,pendiente,anulado',
            'id_asiento' => 'nullable|exists:asientos,id',
        ]);

        $pago->update($request->all());
        return response()->json($pago->load(['alumno', 'concepto', 'periodo', 'moneda', 'metodoPago', 'asiento']));
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();
        return response()->json(null, 204);
    }
}

