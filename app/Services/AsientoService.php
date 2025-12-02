<?php

namespace App\Services;

use App\Models\Asiento;
use App\Models\DetalleAsiento;
use App\Models\CuentaAnalitica;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsientoService
{
    /**
     * Crear un asiento automático para un pago de alumno
     * 
     * @param object $pago - El modelo Pago creado
     * @return Asiento|null
     */
    public static function crearAsientoPago($pago)
    {
        try {
            return DB::transaction(function () use ($pago) {
                // Crear el asiento
                $numeroAsiento = NumeracionService::generarNumero('asiento', 'ASI');
                
                $asiento = Asiento::create([
                    'fecha' => $pago->fecha_pago,
                    'glosa' => "Pago de {$pago->concepto->nombre} - Alumno: {$pago->alumno->nombre_completo}",
                    'estado' => true,
                    'usuario_id' => Auth::id(),
                    'numero_asiento' => $numeroAsiento,
                    'serie' => 'ASI',
                ]);

                // Buscar cuentas analíticas para:
                // 1. Cuenta de ingresos (Caja/Banco)
                // 2. Cuenta de concepto de ingreso

                // DEBE: Caja (cuenta 1010 - Caja y Equivalentes)
                $cuentaCaja = CuentaAnalitica::whereHas('cuentaPrincipal.subgrupo.grupo.clase', function ($q) {
                    $q->where('codigo', '1'); // Activos
                })->where('codigo', '1010')->first();

                // HABER: Ingresos por Concepto (cuenta 4001 - Ingresos por Matrícula, etc.)
                $cuentaIngreso = CuentaAnalitica::whereHas('cuentaPrincipal.subgrupo.grupo.clase', function ($q) {
                    $q->where('codigo', '4'); // Ingresos
                })->first();

                if ($cuentaCaja && $cuentaIngreso) {
                    // Detalle DEBE
                    DetalleAsiento::create([
                        'asiento_id' => $asiento->id,
                        'cuenta_analitica_id' => $cuentaCaja->id_cuenta_analitica,
                        'debe' => $pago->monto,
                        'haber' => 0,
                        'glosa' => "Ingreso por {$pago->concepto->nombre}",
                        'metodo_pago_id' => $pago->id_metodo_pago,
                    ]);

                    // Detalle HABER
                    DetalleAsiento::create([
                        'asiento_id' => $asiento->id,
                        'cuenta_analitica_id' => $cuentaIngreso->id_cuenta_analitica,
                        'debe' => 0,
                        'haber' => $pago->monto,
                        'glosa' => "Ingreso por {$pago->concepto->nombre}",
                        'metodo_pago_id' => $pago->id_metodo_pago,
                    ]);

                    // Vincular el asiento al pago
                    $pago->update(['id_asiento' => $asiento->id]);

                    return $asiento;
                }

                return null;
            });
        } catch (\Exception $e) {
            \Log::error('Error al crear asiento de pago: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Crear un asiento automático para un egreso
     * 
     * @param object $egreso - El modelo Egreso creado
     * @return Asiento|null
     */
    public static function crearAsientoEgreso($egreso)
    {
        try {
            return DB::transaction(function () use ($egreso) {
                // Crear el asiento
                $numeroAsiento = NumeracionService::generarNumero('asiento', 'ASI');
                
                $nombreCategoria = $egreso->categoria ? $egreso->categoria->nombre : 'Gastos';
                $proveedorInfo = $egreso->proveedor ? " - Proveedor: {$egreso->proveedor->nombre}" : "";
                $glosa = "Egreso de {$nombreCategoria}" . $proveedorInfo;
                
                $asiento = Asiento::create([
                    'fecha' => $egreso->fecha,
                    'glosa' => $glosa,
                    'estado' => true,
                    'usuario_id' => Auth::id(),
                    'numero_asiento' => $numeroAsiento,
                    'serie' => 'ASI',
                ]);

                // Buscar cuentas analíticas para:
                // 1. Cuenta de gastos (según categoría)
                // 2. Cuenta de banco/caja (1010)

                // DEBE: Gasto (Categoría de Egreso)
                $cuentaGasto = CuentaAnalitica::whereHas('cuentaPrincipal.subgrupo.grupo.clase', function ($q) {
                    $q->where('codigo', '5'); // Gastos
                })->first();

                // HABER: Caja/Banco (cuenta 1010)
                $cuentaCaja = CuentaAnalitica::whereHas('cuentaPrincipal.subgrupo.grupo.clase', function ($q) {
                    $q->where('codigo', '1'); // Activos
                })->where('codigo', '1010')->first();

                if ($cuentaGasto && $cuentaCaja) {
                    // Detalle DEBE
                    DetalleAsiento::create([
                        'asiento_id' => $asiento->id,
                        'cuenta_analitica_id' => $cuentaGasto->id_cuenta_analitica,
                        'debe' => $egreso->monto,
                        'haber' => 0,
                        'glosa' => "Egreso de " . ($egreso->categoria ? $egreso->categoria->nombre : 'Gastos'),
                        'metodo_pago_id' => null,
                    ]);

                    // Detalle HABER
                    DetalleAsiento::create([
                        'asiento_id' => $asiento->id,
                        'cuenta_analitica_id' => $cuentaCaja->id_cuenta_analitica,
                        'debe' => 0,
                        'haber' => $egreso->monto,
                        'glosa' => "Pago de egreso",
                        'metodo_pago_id' => null,
                    ]);

                    // Vincular el asiento al egreso
                    $egreso->update(['id_asiento' => $asiento->id]);

                    return $asiento;
                }

                return null;
            });
        } catch (\Exception $e) {
            \Log::error('Error al crear asiento de egreso: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Actualizar asiento cuando se modifica un pago
     */
    public static function actualizarAsientoPago($pago, $datosAnteriores)
    {
        if ($pago->id_asiento) {
            $asiento = Asiento::find($pago->id_asiento);
            if ($asiento) {
                // Actualizar la glosa
                $asiento->update([
                    'glosa' => "Pago de {$pago->concepto->nombre} - Alumno: {$pago->alumno->nombre_completo}",
                ]);

                // Actualizar detalles si el monto cambió
                if ($pago->monto != $datosAnteriores['monto']) {
                    foreach ($asiento->detalleAsientos as $detalle) {
                        if ($detalle->debe > 0) {
                            $detalle->update(['debe' => $pago->monto]);
                        } else {
                            $detalle->update(['haber' => $pago->monto]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Actualizar asiento cuando se modifica un egreso
     */
    public static function actualizarAsientoEgreso($egreso, $datosAnteriores)
    {
        if ($egreso->id_asiento) {
            $asiento = Asiento::find($egreso->id_asiento);
            if ($asiento) {
                // Actualizar la glosa
                $nombreCategoria = $egreso->categoria ? $egreso->categoria->nombre : 'Gastos';
                $proveedorInfo = $egreso->proveedor ? " - Proveedor: {$egreso->proveedor->nombre}" : "";
                $asiento->update([
                    'glosa' => "Egreso de {$nombreCategoria}" . $proveedorInfo,
                ]);

                // Actualizar detalles si el monto cambió
                if ($egreso->monto != $datosAnteriores['monto']) {
                    foreach ($asiento->detalleAsientos as $detalle) {
                        if ($detalle->debe > 0) {
                            $detalle->update(['debe' => $egreso->monto]);
                        } else {
                            $detalle->update(['haber' => $egreso->monto]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Eliminar asiento cuando se elimina un pago/egreso
     */
    public static function eliminarAsiento($asientoId)
    {
        try {
            return DB::transaction(function () use ($asientoId) {
                $asiento = Asiento::find($asientoId);
                if ($asiento) {
                    // Eliminar detalles primero
                    DetalleAsiento::where('asiento_id', $asiento->id)->delete();
                    // Luego eliminar el asiento
                    $asiento->delete();
                    return true;
                }
                return false;
            });
        } catch (\Exception $e) {
            \Log::error('Error al eliminar asiento: ' . $e->getMessage());
            return false;
        }
    }
}
