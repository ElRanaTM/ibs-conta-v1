<?php

namespace App\Http\Controllers;

use App\Models\ClaseCuenta;
use App\Models\Grupo;
use App\Models\Subgrupo;
use App\Models\CuentaPrincipal;
use App\Models\CuentaAnalitica;
use Illuminate\Http\Request;

class CuentaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tipo_cuenta' => 'required|in:clase,grupo,subgrupo,principal,analitica',
            'codigo' => 'required|string',
            'nombre' => 'required|string',
            'parent_id' => 'required_if:tipo_cuenta,grupo,subgrupo,principal,analitica',
            'es_auxiliar' => 'boolean',
        ]);

        try {
            switch ($request->tipo_cuenta) {
                case 'clase':
                    ClaseCuenta::create([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre,
                    ]);
                    break;
                    
                case 'grupo':
                    Grupo::create([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre,
                        'clase_id' => $request->parent_id,
                    ]);
                    break;
                    
                case 'subgrupo':
                    Subgrupo::create([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre,
                        'grupo_id' => $request->parent_id,
                    ]);
                    break;
                    
                case 'principal':
                    CuentaPrincipal::create([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre,
                        'subgrupo_id' => $request->parent_id,
                    ]);
                    break;
                    
                case 'analitica':
                    CuentaAnalitica::create([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre,
                        'cuenta_principal_id' => $request->parent_id,
                        'es_auxiliar' => $request->has('es_auxiliar'),
                    ]);
                    break;
            }

            return redirect()->route('cuentas.plan-cuentas')->with('success', 'Cuenta creada exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear la cuenta: ' . $e->getMessage()])->withInput();
        }
    }
}

