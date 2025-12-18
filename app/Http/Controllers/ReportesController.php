<?php

namespace App\Http\Controllers;

use App\Models\CuentaAnalitica;
use App\Services\PdfService;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    /**
     * Mostrar vista del Balance de Comprobación
     */
    public function balanceComprobacion(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde');
        $fechaHasta = $request->get('fecha_hasta');
        $cuentas = collect();

        if ($fechaDesde && $fechaHasta) {
            // Consulta para obtener sumas y saldos por cuenta analítica
            $cuentas = \App\Models\DetalleAsiento::select(
                    'cuentas_analiticas.id',
                    'cuentas_analiticas.codigo',
                    'cuentas_analiticas.nombre',
                    \Illuminate\Support\Facades\DB::raw('SUM(detalle_asientos.debe) as total_debe'),
                    \Illuminate\Support\Facades\DB::raw('SUM(detalle_asientos.haber) as total_haber')
                )
                ->join('cuentas_analiticas', 'detalle_asientos.cuenta_analitica_id', '=', 'cuentas_analiticas.id')
                ->join('asientos', 'detalle_asientos.asiento_id', '=', 'asientos.id')
                ->whereBetween('asientos.fecha', [$fechaDesde, $fechaHasta])
                ->where('asientos.estado', true)
                ->groupBy('cuentas_analiticas.id', 'cuentas_analiticas.codigo', 'cuentas_analiticas.nombre')
                ->orderBy('cuentas_analiticas.codigo')
                ->get()
                ->map(function ($cuenta) {
                    $saldoDeudor = max(0, $cuenta->total_debe - $cuenta->total_haber);
                    $saldoAcreedor = max(0, $cuenta->total_haber - $cuenta->total_debe);

                    return [
                        'codigo' => $cuenta->codigo,
                        'nombre' => $cuenta->nombre,
                        'saldo_deudor' => $saldoDeudor,
                        'saldo_acreedor' => $saldoAcreedor,
                    ];
                });
        }

        $totalSaldoDeudor = $cuentas->sum('saldo_deudor');
        $totalSaldoAcreedor = $cuentas->sum('saldo_acreedor');

        return view('contabilidad.reportes.balance-comprobacion', compact('cuentas', 'fechaDesde', 'fechaHasta', 'totalSaldoDeudor', 'totalSaldoAcreedor'));
    }

    /**
     * Generar PDF del Balance de Comprobación
     */
    public function balanceComprobacionPdf(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde', date('Y-m-01'));
        $fechaHasta = $request->get('fecha_hasta', date('Y-m-d'));

        return $this->pdfService->generarBalanceComprobacion($fechaDesde, $fechaHasta);
    }

    /**
     * Mostrar vista del Mayor General
     */
    public function mayorGeneral(Request $request)
    {
        $cuentas = CuentaAnalitica::select('id', 'codigo', 'nombre')
            ->orderBy('codigo')
            ->get();

        $cuentaId = $request->get('cuenta_id');
        $fechaDesde = $request->get('fecha_desde');
        $fechaHasta = $request->get('fecha_hasta');
        $movimientos = collect();
        $cuentaSeleccionada = null;

        if ($cuentaId && $fechaDesde && $fechaHasta) {
            $cuentaSeleccionada = CuentaAnalitica::find($cuentaId);

            // Obtener movimientos de la cuenta
            $movimientosQuery = \App\Models\DetalleAsiento::select(
                    'asientos.fecha',
                    'asientos.numero_asiento',
                    'asientos.glosa',
                    'detalle_asientos.debe',
                    'detalle_asientos.haber'
                )
                ->join('asientos', 'detalle_asientos.asiento_id', '=', 'asientos.id')
                ->where('detalle_asientos.cuenta_analitica_id', $cuentaId)
                ->whereBetween('asientos.fecha', [$fechaDesde, $fechaHasta])
                ->where('asientos.estado', true)
                ->orderBy('asientos.fecha')
                ->orderBy('asientos.id')
                ->get();

            // Calcular saldos acumulados
            $saldoAcumulado = 0;
            $movimientos = $movimientosQuery->map(function ($mov) use (&$saldoAcumulado) {
                $saldoAcumulado += $mov->debe - $mov->haber;
                return [
                    'fecha' => $mov->fecha,
                    'numero_asiento' => $mov->numero_asiento,
                    'glosa' => $mov->glosa,
                    'debe' => $mov->debe,
                    'haber' => $mov->haber,
                    'saldo' => $saldoAcumulado,
                ];
            });
        }

        return view('contabilidad.reportes.mayor-general', compact('cuentas', 'movimientos', 'cuentaSeleccionada', 'fechaDesde', 'fechaHasta'));
    }

    /**
     * Generar PDF del Mayor General
     */
    public function mayorGeneralPdf(Request $request)
    {
        $cuentaId = $request->get('cuenta_id');
        $fechaDesde = $request->get('fecha_desde', date('Y-m-01'));
        $fechaHasta = $request->get('fecha_hasta', date('Y-m-d'));

        if (!$cuentaId) {
            return redirect()->back()->with('error', 'Debe seleccionar una cuenta.');
        }

        return $this->pdfService->generarMayorGeneral($cuentaId, $fechaDesde, $fechaHasta);
    }

    /**
     * Generar PDF del Libro Diario
     */
    public function libroDiarioPdf(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde', date('Y-m-01'));
        $fechaHasta = $request->get('fecha_hasta', date('Y-m-d'));

        return $this->pdfService->generarLibroDiario($fechaDesde, $fechaHasta);
    }
}