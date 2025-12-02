<?php

namespace App\Http\Controllers;

use App\Models\CuentaAnalitica;
use App\Models\DetalleAsiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SumasSaldosController extends Controller
{
    public function index(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde', date('Y-m-01'));
        $fechaHasta = $request->get('fecha_hasta', date('Y-m-d'));
        
        // Obtener sumas y saldos por cuenta analítica
        $sumasSaldos = DetalleAsiento::select(
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
            ->get()
            ->map(function ($item) {
                $deudor = max(0, $item->total_debe - $item->total_haber);
                $acreedor = max(0, $item->total_haber - $item->total_debe);
                
                // Determinar si es activo o pasivo basado en el código
                $codigo = (int) substr($item->codigo, 0, 1);
                $esActivo = in_array($codigo, [1]); // Clase 1 = Activos
                $esPasivo = in_array($codigo, [2]); // Clase 2 = Pasivos
                $esIngreso = in_array($codigo, [4]); // Clase 4 = Ingresos
                $esEgreso = in_array($codigo, [5]); // Clase 5 = Egresos
                
                return [
                    'id' => $item->id,
                    'codigo' => $item->codigo,
                    'cuenta' => $item->nombre,
                    'debe' => $item->total_debe ?? 0,
                    'haber' => $item->total_haber ?? 0,
                    'deudor' => $deudor,
                    'acreedor' => $acreedor,
                    'ingreso' => $esIngreso ? $acreedor : 0,
                    'egreso' => $esEgreso ? $deudor : 0,
                    'activo' => $esActivo ? $deudor : 0,
                    'pasivo' => $esPasivo ? $acreedor : 0,
                ];
            });
        
        return view('contabilidad.sumas-saldos', compact('sumasSaldos', 'fechaDesde', 'fechaHasta'));
    }

    public function exportCsv(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde', date('Y-m-01'));
        $fechaHasta = $request->get('fecha_hasta', date('Y-m-d'));

        $sumasSaldos = $this->indexData($fechaDesde, $fechaHasta);

        $filename = "sumas_saldos_{$fechaDesde}_{$fechaHasta}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($sumasSaldos) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Código', 'Cuenta', 'Debe', 'Haber', 'Deudor', 'Acreedor', 'Ingreso', 'Egreso', 'Activo', 'Pasivo']);

            foreach ($sumasSaldos as $item) {
                fputcsv($out, [
                    $item['codigo'],
                    $item['cuenta'],
                    number_format($item['debe'], 2, '.', ''),
                    number_format($item['haber'], 2, '.', ''),
                    number_format($item['deudor'], 2, '.', ''),
                    number_format($item['acreedor'], 2, '.', ''),
                    number_format($item['ingreso'], 2, '.', ''),
                    number_format($item['egreso'], 2, '.', ''),
                    number_format($item['activo'], 2, '.', ''),
                    number_format($item['pasivo'], 2, '.', ''),
                ]);
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPrint(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde', date('Y-m-01'));
        $fechaHasta = $request->get('fecha_hasta', date('Y-m-d'));

        $sumasSaldos = $this->indexData($fechaDesde, $fechaHasta);

        return view('contabilidad.sumas-saldos-print', compact('sumasSaldos', 'fechaDesde', 'fechaHasta'));
    }

    // helper to reuse the same query logic
    protected function indexData($fechaDesde, $fechaHasta)
    {
        return DetalleAsiento::select(
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
            ->get()
            ->map(function ($item) {
                $deudor = max(0, $item->total_debe - $item->total_haber);
                $acreedor = max(0, $item->total_haber - $item->total_debe);

                $codigo = (int) substr($item->codigo, 0, 1);
                $esActivo = in_array($codigo, [1]);
                $esPasivo = in_array($codigo, [2]);
                $esIngreso = in_array($codigo, [4]);
                $esEgreso = in_array($codigo, [5]);

                return [
                    'id' => $item->id,
                    'codigo' => $item->codigo,
                    'cuenta' => $item->nombre,
                    'debe' => $item->total_debe ?? 0,
                    'haber' => $item->total_haber ?? 0,
                    'deudor' => $deudor,
                    'acreedor' => $acreedor,
                    'ingreso' => $esIngreso ? $acreedor : 0,
                    'egreso' => $esEgreso ? $deudor : 0,
                    'activo' => $esActivo ? $deudor : 0,
                    'pasivo' => $esPasivo ? $acreedor : 0,
                ];
            });
    }
}

