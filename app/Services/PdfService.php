<?php

namespace App\Services;

use App\Models\Asiento;
use App\Models\CuentaAnalitica;
use App\Models\DetalleAsiento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PdfService
{
    /**
     * Generar PDF del Balance de Comprobación
     */
    public function generarBalanceComprobacion($fechaDesde, $fechaHasta)
    {
        // Consulta para obtener sumas y saldos por cuenta analítica
        $cuentas = DetalleAsiento::select(
                'cuentas_analiticas.id',
                'cuentas_analiticas.codigo',
                'cuentas_analiticas.nombre',
                DB::raw('SUM(detalle_asientos.debe) as total_debe'),
                DB::raw('SUM(detalle_asientos.haber) as total_haber')
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
                    'debe' => $cuenta->total_debe,
                    'haber' => $cuenta->total_haber,
                    'saldo_deudor' => $saldoDeudor,
                    'saldo_acreedor' => $saldoAcreedor,
                ];
            });

        $totalDebe = $cuentas->sum('debe');
        $totalHaber = $cuentas->sum('haber');
        $totalSaldoDeudor = $cuentas->sum('saldo_deudor');
        $totalSaldoAcreedor = $cuentas->sum('saldo_acreedor');

        $data = [
            'cuentas' => $cuentas,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'totalDebe' => $totalDebe,
            'totalHaber' => $totalHaber,
            'totalSaldoDeudor' => $totalSaldoDeudor,
            'totalSaldoAcreedor' => $totalSaldoAcreedor,
            'titulo' => 'Balance de Comprobación',
        ];

        $pdf = Pdf::loadView('pdfs.balance-comprobacion', $data);
        return $pdf->download('balance-comprobacion.pdf');
    }

    /**
     * Generar PDF del Mayor General
     */
    public function generarMayorGeneral($cuentaId, $fechaDesde, $fechaHasta)
    {
        $cuenta = CuentaAnalitica::findOrFail($cuentaId);

        // Obtener movimientos de la cuenta
        $movimientos = DetalleAsiento::select(
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
        $movimientosConSaldo = $movimientos->map(function ($mov) use (&$saldoAcumulado) {
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

        $data = [
            'cuenta' => $cuenta,
            'movimientos' => $movimientosConSaldo,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'titulo' => 'Mayor General - ' . $cuenta->codigo . ' ' . $cuenta->nombre,
        ];

        $pdf = Pdf::loadView('pdfs.mayor-general', $data);
        return $pdf->download('mayor-general-' . $cuenta->codigo . '.pdf');
    }

    /**
     * Generar PDF del Libro Diario (Asientos)
     */
    public function generarLibroDiario($fechaDesde, $fechaHasta)
    {
        $asientos = Asiento::with(['detalleAsientos.cuentaAnalitica'])
            ->whereBetween('fecha', [$fechaDesde, $fechaHasta])
            ->where('estado', true)
            ->orderBy('fecha')
            ->orderBy('id')
            ->get();

        $data = [
            'asientos' => $asientos,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'titulo' => 'Libro Diario',
        ];

        $pdf = Pdf::loadView('pdfs.libro-diario', $data);
        return $pdf->download('libro-diario.pdf');
    }
}