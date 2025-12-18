<?php

namespace App\Http\Controllers;

use App\Models\Asiento;
use App\Models\CuentaAnalitica;
use App\Models\DetalleAsiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->format('Y-m');

        // Total ingresos del mes (cuentas de ingresos)
        $totalIngresos = DetalleAsiento::join('asientos', 'detalle_asientos.asiento_id', '=', 'asientos.id')
            ->join('cuentas_analiticas', 'detalle_asientos.cuenta_analitica_id', '=', 'cuentas_analiticas.id')
            ->where('asientos.estado', true)
            ->whereRaw("DATE_FORMAT(asientos.fecha, '%Y-%m') = ?", [$currentMonth])
            ->whereRaw("LEFT(cuentas_analiticas.codigo, 1) = '4'") // Cuentas de ingresos
            ->sum('detalle_asientos.haber');

        // Total egresos del mes (cuentas de egresos)
        $totalEgresos = DetalleAsiento::join('asientos', 'detalle_asientos.asiento_id', '=', 'asientos.id')
            ->join('cuentas_analiticas', 'detalle_asientos.cuenta_analitica_id', '=', 'cuentas_analiticas.id')
            ->where('asientos.estado', true)
            ->whereRaw("DATE_FORMAT(asientos.fecha, '%Y-%m') = ?", [$currentMonth])
            ->whereRaw("LEFT(cuentas_analiticas.codigo, 1) = '5'") // Cuentas de egresos
            ->sum('detalle_asientos.debe');

        // Saldo actual (activos - pasivos)
        $totalActivos = DetalleAsiento::join('asientos', 'detalle_asientos.asiento_id', '=', 'asientos.id')
            ->join('cuentas_analiticas', 'detalle_asientos.cuenta_analitica_id', '=', 'cuentas_analiticas.id')
            ->where('asientos.estado', true)
            ->whereRaw("LEFT(cuentas_analiticas.codigo, 1) = '1'") // Activos
            ->sum(DB::raw('detalle_asientos.debe - detalle_asientos.haber'));

        $totalPasivos = DetalleAsiento::join('asientos', 'detalle_asientos.asiento_id', '=', 'asientos.id')
            ->join('cuentas_analiticas', 'detalle_asientos.cuenta_analitica_id', '=', 'cuentas_analiticas.id')
            ->where('asientos.estado', true)
            ->whereRaw("LEFT(cuentas_analiticas.codigo, 1) = '2'") // Pasivos
            ->sum(DB::raw('detalle_asientos.haber - detalle_asientos.debe'));

        $saldoActual = $totalActivos - $totalPasivos;

        // Asientos del mes
        $asientosMes = Asiento::where('estado', true)
            ->whereRaw("DATE_FORMAT(fecha, '%Y-%m') = ?", [$currentMonth])
            ->count();

        // Cuentas activas
        $cuentasActivas = CuentaAnalitica::count();

        // Últimos asientos
        $ultimosAsientos = Asiento::with(['usuario', 'detalleAsientos.cuentaAnalitica'])
            ->where('estado', true)
            ->latest()
            ->take(5)
            ->get();

        // Últimos pagos (asumiendo que hay una tabla pagos o buscar en asientos)
        $ultimosPagos = collect(); // Por ahora vacío, implementar cuando haya modelo Pago

        return view('dashboard.index', compact(
            'totalIngresos',
            'totalEgresos',
            'saldoActual',
            'asientosMes',
            'cuentasActivas',
            'ultimosAsientos',
            'ultimosPagos'
        ));
    }
}