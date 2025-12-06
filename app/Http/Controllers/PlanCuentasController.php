<?php

namespace App\Http\Controllers;

use App\Models\ClaseCuenta;
use App\Models\DetalleAsiento;
use Illuminate\Http\Request;

class PlanCuentasController extends Controller
{
    public function planCuentas()
    {
        $clases = ClaseCuenta::with([
            'grupos.subgrupos.cuentasPrincipales.cuentasAnaliticas.detalleAsientos'
        ])->get();
        
        // Calcular saldos para cada cuenta analítica
        $saldos = [];
        $clases->each(function($clase) use (&$saldos) {
            $clase->grupos->each(function($grupo) use (&$saldos) {
                $grupo->subgrupos->each(function($subgrupo) use (&$saldos) {
                    $subgrupo->cuentasPrincipales->each(function($principal) use (&$saldos) {
                        $principal->cuentasAnaliticas->each(function($cuenta) use (&$saldos) {
                            // Calcular total Debe y Haber para esta cuenta analítica
                            $totalDebe = $cuenta->detalleAsientos->sum('debe');
                            $totalHaber = $cuenta->detalleAsientos->sum('haber');
                            
                            $saldos[$cuenta->id] = [
                                'debe' => $totalDebe,
                                'haber' => $totalHaber
                            ];
                        });
                    });
                });
            });
        });
        
        return view('contabilidad.cuentas.plan-cuentas', compact('clases', 'saldos'));
    }

    public function planCuentasManage()
    {
        $clases = ClaseCuenta::with([
            'grupos.subgrupos.cuentasPrincipales.cuentasAnaliticas'
        ])->get();

        return view('contabilidad.cuentas.plan-cuentas-manage', compact('clases'));
    }
}