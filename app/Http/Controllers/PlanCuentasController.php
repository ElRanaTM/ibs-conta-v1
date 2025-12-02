<?php

namespace App\Http\Controllers;

use App\Models\ClaseCuenta;
use Illuminate\Http\Request;

class PlanCuentasController extends Controller
{
    public function planCuentas()
    {
        $clases = ClaseCuenta::with([
            'grupos.subgrupos.cuentasPrincipales.cuentasAnaliticas'
        ])->get();
        
        return view('contabilidad.cuentas.plan-cuentas', compact('clases'));
    }

    public function planCuentasManage()
    {
        $clases = ClaseCuenta::with([
            'grupos.subgrupos.cuentasPrincipales.cuentasAnaliticas'
        ])->get();

        return view('contabilidad.cuentas.plan-cuentas-manage', compact('clases'));
    }
}

