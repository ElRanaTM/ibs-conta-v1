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
    public function create()
    {
        $clases = ClaseCuenta::all();
        $grupos = Grupo::all();
        $subgrupos = Subgrupo::all();
        $cuentasPrincipales = CuentaPrincipal::all();
        return view('cuentas.create', compact('clases', 'grupos', 'subgrupos', 'cuentasPrincipales'));
    }

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

    public function edit($id)
    {
        // Buscar la cuenta en todos los tipos posibles
        $cuenta = null;
        $tipo = null;

        if ($clase = ClaseCuenta::find($id)) {
            $cuenta = $clase;
            $tipo = 'clase';
        } elseif ($grupo = Grupo::find($id)) {
            $cuenta = $grupo;
            $tipo = 'grupo';
        } elseif ($subgrupo = Subgrupo::find($id)) {
            $cuenta = $subgrupo;
            $tipo = 'subgrupo';
        } elseif ($principal = CuentaPrincipal::find($id)) {
            $cuenta = $principal;
            $tipo = 'principal';
        } elseif ($analitica = CuentaAnalitica::find($id)) {
            $cuenta = $analitica;
            $tipo = 'analitica';
        }

        if (!$cuenta) {
            return redirect()->route('cuentas.plan-cuentas')->withErrors(['error' => 'Cuenta no encontrada.']);
        }

        $clases = ClaseCuenta::all();
        $grupos = Grupo::all();
        $subgrupos = Subgrupo::all();
        $cuentasPrincipales = CuentaPrincipal::all();

        return view('cuentas.edit', compact('cuenta', 'tipo', 'clases', 'grupos', 'subgrupos', 'cuentasPrincipales'));
    }

    public function update(Request $request, $id)
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
                    $cuenta = ClaseCuenta::findOrFail($id);
                    $cuenta->update([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre,
                    ]);
                    break;
                    
                case 'grupo':
                    $cuenta = Grupo::findOrFail($id);
                    $cuenta->update([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre,
                        'clase_id' => $request->parent_id,
                    ]);
                    break;
                    
                case 'subgrupo':
                    $cuenta = Subgrupo::findOrFail($id);
                    $cuenta->update([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre,
                        'grupo_id' => $request->parent_id,
                    ]);
                    break;
                    
                case 'principal':
                    $cuenta = CuentaPrincipal::findOrFail($id);
                    $cuenta->update([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre,
                        'subgrupo_id' => $request->parent_id,
                    ]);
                    break;
                    
                case 'analitica':
                    $cuenta = CuentaAnalitica::findOrFail($id);
                    $cuenta->update([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre,
                        'cuenta_principal_id' => $request->parent_id,
                        'es_auxiliar' => $request->has('es_auxiliar'),
                    ]);
                    break;
            }

            return redirect()->route('cuentas.plan-cuentas')->with('success', 'Cuenta actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar la cuenta: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            // Buscar la cuenta en todos los tipos posibles
            if ($cuenta = ClaseCuenta::find($id)) {
                $cuenta->delete();
            } elseif ($cuenta = Grupo::find($id)) {
                $cuenta->delete();
            } elseif ($cuenta = Subgrupo::find($id)) {
                $cuenta->delete();
            } elseif ($cuenta = CuentaPrincipal::find($id)) {
                $cuenta->delete();
            } elseif ($cuenta = CuentaAnalitica::find($id)) {
                $cuenta->delete();
            } else {
                return redirect()->route('cuentas.plan-cuentas')->withErrors(['error' => 'Cuenta no encontrada.']);
            }

            return redirect()->route('cuentas.plan-cuentas')->with('success', 'Cuenta eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('cuentas.plan-cuentas')->withErrors(['error' => 'Error al eliminar la cuenta: ' . $e->getMessage()]);
        }
    }
}
