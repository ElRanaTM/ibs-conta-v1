<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asiento;
use App\Models\DetalleAsiento;
use App\Models\CuentaAnalitica;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsientosRealistasSeeder extends Seeder
{
    private $cuentasPorTipo = [];
    private $usuarioId;
    
    public function run()
    {
        // Verificar que existan cuentas
        if (CuentaAnalitica::count() == 0) {
            $this->command->error('No hay cuentas analíticas disponibles.');
            return;
        }
        
        // Obtener usuario para los asientos
        $this->usuarioId = User::first()->id ?? 1;
        
        // Organizar cuentas por tipo para facilitar el acceso
        $this->organizarCuentas();
        
        $this->command->info('🎯 GENERANDO ASIENTOS CONTABLES REALISTAS 🎯');
        
        // Crear asientos para cada mes del año anterior
        $totalAsientos = 0;
        $mesActual = Carbon::now()->month;
        $añoActual = Carbon::now()->year;
        
        for ($mes = 1; $mes <= 12; $mes++) {
            $año = ($mes > $mesActual) ? $añoActual - 1 : $añoActual;
            
            $asientosMes = $this->crearAsientosParaMes($mes, $año);
            $totalAsientos += $asientosMes;
            
            $nombreMes = Carbon::create($año, $mes, 1)->locale('es')->monthName;
            $this->command->info("✅ $nombreMes $año: $asientosMes asientos creados");
        }
        
        $this->command->info("\n🎉 TOTAL: $totalAsientos asientos creados exitosamente!");
        $this->mostrarEstadisticas();
    }
    
    private function organizarCuentas()
    {
        $todasCuentas = CuentaAnalitica::all();
        
        foreach ($todasCuentas as $cuenta) {
            $primerDigito = substr($cuenta->codigo, 0, 1);
            
            switch ($primerDigito) {
                case '1':
                    $this->cuentasPorTipo['activos'][] = $cuenta->id;
                    break;
                case '2':
                    $this->cuentasPorTipo['pasivos'][] = $cuenta->id;
                    break;
                case '3':
                    $this->cuentasPorTipo['patrimonio'][] = $cuenta->id;
                    break;
                case '4':
                    $this->cuentasPorTipo['ingresos'][] = $cuenta->id;
                    break;
                case '5':
                    $this->cuentasPorTipo['gastos'][] = $cuenta->id;
                    break;
            }
            
            // Detectar cuentas específicas por nombre
            $nombre = strtoupper($cuenta->nombre);
            if (str_contains($nombre, 'CAJA') || str_contains($nombre, 'BANCO')) {
                $this->cuentasPorTipo['caja_banco'][] = $cuenta->id;
            }
            if (str_contains($nombre, 'CLIENTE') || str_contains($nombre, 'DEUDOR')) {
                $this->cuentasPorTipo['clientes'][] = $cuenta->id;
            }
            if (str_contains($nombre, 'PROVEEDOR')) {
                $this->cuentasPorTipo['proveedores'][] = $cuenta->id;
            }
            if (str_contains($nombre, 'VENTA')) {
                $this->cuentasPorTipo['ventas'][] = $cuenta->id;
            }
            if (str_contains($nombre, 'COSTO') || str_contains($nombre, 'MATERIA PRIMA')) {
                $this->cuentasPorTipo['costos'][] = $cuenta->id;
            }
            if (str_contains($nombre, 'SUELDO') || str_contains($nombre, 'SALARIO')) {
                $this->cuentasPorTipo['sueldos'][] = $cuenta->id;
            }
            if (str_contains($nombre, 'DEPRECIACIÓN') || str_contains($nombre, 'AMORTIZACIÓN')) {
                $this->cuentasPorTipo['depreciacion'][] = $cuenta->id;
            }
        }
    }
    
    private function crearAsientosParaMes($mes, $año)
    {
        $contador = 0;
        $diasEnMes = Carbon::create($año, $mes, 1)->daysInMonth;
        
        // Cantidad de asientos según el mes (más actividad en ciertos meses)
        $asientosPorMes = [
            1 => 12,  // Enero - inicio de año
            2 => 10,
            3 => 15,  // Marzo - cierre trimestre
            4 => 12,
            5 => 14,
            6 => 18,  // Junio - mitad de año
            7 => 12,
            8 => 13,
            9 => 16,  // Septiembre - cierre trimestre
            10 => 14,
            11 => 15,
            12 => 20, // Diciembre - cierre anual
        ];
        
        $cantidad = $asientosPorMes[$mes];
        
        for ($i = 1; $i <= $cantidad; $i++) {
            // Distribuir los asientos a lo largo del mes
            $dia = min($i * floor($diasEnMes / $cantidad), $diasEnMes);
            $fecha = Carbon::create($año, $mes, $dia)->format('Y-m-d');
            
            // Crear diferentes tipos de asientos
            $tipoAsiento = $this->determinarTipoAsiento($mes, $i);
            $asiento = $this->crearAsiento($fecha, $tipoAsiento);
            
            if ($asiento) {
                $this->crearDetallesPorTipo($asiento->id, $tipoAsiento);
                $contador++;
                
                // Verificar balance
                $this->verificarBalance($asiento->id);
            }
        }
        
        // Asientos especiales para ciertos meses
        if ($mes == 3 || $mes == 6 || $mes == 9 || $mes == 12) {
            $this->crearAsientosCierreTrimestre($mes, $año);
            $contador += 3;
        }
        
        if ($mes == 12) {
            $this->crearAsientosCierreAnual($año);
            $contador += 5;
        }
        
        return $contador;
    }
    
    private function determinarTipoAsiento($mes, $indice)
    {
        $tipos = [
            'compra_mercaderia',
            'venta_contado',
            'venta_credito',
            'pago_proveedores',
            'cobro_clientes',
            'pago_sueldos',
            'gastos_operativos',
            'depreciacion',
            'ajuste_inventario',
            'gastos_financieros',
        ];
        
        // Priorizar ciertos tipos según el mes
        if ($mes == 1) {
            $tipos = array_merge(['compra_mercaderia', 'compra_mercaderia', 'pago_proveedores']);
        } elseif ($mes == 12) {
            $tipos = array_merge(['ajuste_inventario', 'depreciacion', 'gastos_operativos']);
        }
        
        return $tipos[array_rand($tipos)];
    }
    
    private function crearAsiento($fecha, $tipo)
    {
        $glosas = [
            'compra_mercaderia' => 'Compra de materia prima para producción',
            'venta_contado' => 'Venta de productos al contado',
            'venta_credito' => 'Venta de productos a crédito 30 días',
            'pago_proveedores' => 'Pago a proveedores nacionales',
            'cobro_clientes' => 'Cobranza de clientes morosos',
            'pago_sueldos' => 'Pago de planilla de sueldos y salarios',
            'gastos_operativos' => 'Pago de servicios básicos y gastos administrativos',
            'depreciacion' => 'Registro de depreciación mensual de activos fijos',
            'ajuste_inventario' => 'Ajuste de inventario por merma controlada',
            'gastos_financieros' => 'Pago de intereses por préstamo bancario',
        ];
        
        $ultimoNumero = Asiento::count() + 1;
        
        return Asiento::create([
            'fecha' => $fecha,
            'glosa' => $glosas[$tipo] ?? 'Asiento contable del mes',
            'estado' => true,
            'usuario_id' => $this->usuarioId,
            'numero_asiento' => 'ASI-' . str_pad($ultimoNumero, 6, '0', STR_PAD_LEFT),
            'serie' => 'ASI',
        ]);
    }
    
    private function crearDetallesPorTipo($asientoId, $tipo)
    {
        $detalles = [];
        
        switch ($tipo) {
            case 'compra_mercaderia':
                $detalles = $this->detallesCompraMercaderia($asientoId);
                break;
            case 'venta_contado':
                $detalles = $this->detallesVentaContado($asientoId);
                break;
            case 'venta_credito':
                $detalles = $this->detallesVentaCredito($asientoId);
                break;
            case 'pago_proveedores':
                $detalles = $this->detallesPagoProveedores($asientoId);
                break;
            case 'cobro_clientes':
                $detalles = $this->detallesCobroClientes($asientoId);
                break;
            case 'pago_sueldos':
                $detalles = $this->detallesPagoSueldos($asientoId);
                break;
            case 'gastos_operativos':
                $detalles = $this->detallesGastosOperativos($asientoId);
                break;
            case 'depreciacion':
                $detalles = $this->detallesDepreciacion($asientoId);
                break;
            case 'ajuste_inventario':
                $detalles = $this->detallesAjusteInventario($asientoId);
                break;
            case 'gastos_financieros':
                $detalles = $this->detallesGastosFinancieros($asientoId);
                break;
            default:
                $detalles = $this->detallesGenericos($asientoId);
        }
        
        // Insertar detalles
        foreach ($detalles as $detalle) {
            DetalleAsiento::create($detalle);
        }
    }
    
    private function detallesCompraMercaderia($asientoId)
    {
        $monto = rand(5000, 25000) + (rand(0, 99) / 100);
        
        return [
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('costos'),
                'debe' => $monto,
                'haber' => 0,
                'glosa' => 'Compra de materia prima cuero',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('proveedores'),
                'debe' => 0,
                'haber' => $monto * 0.85,
                'glosa' => 'Por pagar a proveedor',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuenta('iva'),
                'debe' => $monto * 0.15,
                'haber' => 0,
                'glosa' => 'IVA crédito fiscal',
            ]
        ];
    }
    
    private function detallesVentaContado($asientoId)
    {
        $monto = rand(3000, 15000) + (rand(0, 99) / 100);
        
        return [
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('caja_banco'),
                'debe' => $monto,
                'haber' => 0,
                'glosa' => 'Ingreso por venta al contado',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('ventas'),
                'debe' => 0,
                'haber' => $monto * 0.87,
                'glosa' => 'Venta de zapatos nacional',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuenta('iva_debito'),
                'debe' => 0,
                'haber' => $monto * 0.13,
                'glosa' => 'IVA débito fiscal',
            ]
        ];
    }
    
    private function detallesVentaCredito($asientoId)
    {
        $monto = rand(5000, 30000) + (rand(0, 99) / 100);
        
        return [
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('clientes'),
                'debe' => $monto,
                'haber' => 0,
                'glosa' => 'Venta a crédito 30 días',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('ventas'),
                'debe' => 0,
                'haber' => $monto * 0.87,
                'glosa' => 'Venta de calzado deportivo',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuenta('iva_debito'),
                'debe' => 0,
                'haber' => $monto * 0.13,
                'glosa' => 'IVA débito fiscal',
            ]
        ];
    }
    
    private function detallesPagoProveedores($asientoId)
    {
        $monto = rand(2000, 12000) + (rand(0, 99) / 100);
        
        return [
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('proveedores'),
                'debe' => $monto,
                'haber' => 0,
                'glosa' => 'Pago a proveedor nacional',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('caja_banco'),
                'debe' => 0,
                'haber' => $monto,
                'glosa' => 'Transferencia bancaria',
            ]
        ];
    }
    
    private function detallesCobroClientes($asientoId)
    {
        $monto = rand(1500, 8000) + (rand(0, 99) / 100);
        
        return [
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('caja_banco'),
                'debe' => $monto,
                'haber' => 0,
                'glosa' => 'Cobranza de cliente',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('clientes'),
                'debe' => 0,
                'haber' => $monto,
                'glosa' => 'Cancelación de cuenta por cobrar',
            ]
        ];
    }
    
    private function detallesPagoSueldos($asientoId)
    {
        $montoSueldos = rand(8000, 25000) + (rand(0, 99) / 100);
        $montoCargas = $montoSueldos * 0.25; // 25% de cargas sociales
        
        return [
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('sueldos'),
                'debe' => $montoSueldos,
                'haber' => 0,
                'glosa' => 'Sueldos del personal',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuenta('cargas_sociales'),
                'debe' => $montoCargas,
                'haber' => 0,
                'glosa' => 'Cargas sociales',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('caja_banco'),
                'debe' => 0,
                'haber' => $montoSueldos + $montoCargas,
                'glosa' => 'Pago de planilla',
            ]
        ];
    }
    
    private function detallesGastosOperativos($asientoId)
    {
        $monto = rand(500, 3000) + (rand(0, 99) / 100);
        
        return [
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuenta('gastos_generales'),
                'debe' => $monto,
                'haber' => 0,
                'glosa' => 'Pago de servicios básicos',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('caja_banco'),
                'debe' => 0,
                'haber' => $monto,
                'glosa' => 'Transferencia por gastos',
            ]
        ];
    }
    
    private function detallesDepreciacion($asientoId)
    {
        $monto = rand(800, 4000) + (rand(0, 99) / 100);
        
        return [
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('depreciacion'),
                'debe' => $monto,
                'haber' => 0,
                'glosa' => 'Depreciación mensual de activos fijos',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuenta('depreciacion_acumulada'),
                'debe' => 0,
                'haber' => $monto,
                'glosa' => 'Depreciación acumulada',
            ]
        ];
    }
    
    private function detallesAjusteInventario($asientoId)
    {
        $monto = rand(200, 1500) + (rand(0, 99) / 100);
        
        return [
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuenta('costo_ventas'),
                'debe' => $monto,
                'haber' => 0,
                'glosa' => 'Ajuste por merma de inventario',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('costos'),
                'debe' => 0,
                'haber' => $monto,
                'glosa' => 'Reducción de inventario',
            ]
        ];
    }
    
    private function detallesGastosFinancieros($asientoId)
    {
        $monto = rand(500, 2500) + (rand(0, 99) / 100);
        
        return [
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuenta('gastos_financieros'),
                'debe' => $monto,
                'haber' => 0,
                'glosa' => 'Intereses por préstamo bancario',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('caja_banco'),
                'debe' => 0,
                'haber' => $monto,
                'glosa' => 'Pago de intereses',
            ]
        ];
    }
    
    private function detallesGenericos($asientoId)
    {
        $monto = rand(1000, 5000) + (rand(0, 99) / 100);
        
        return [
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('activos'),
                'debe' => $monto,
                'haber' => 0,
                'glosa' => 'Movimiento contable',
            ],
            [
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $this->obtenerCuentaAleatoria('pasivos'),
                'debe' => 0,
                'haber' => $monto,
                'glosa' => 'Contrapartida',
            ]
        ];
    }
    
    private function crearAsientosCierreTrimestre($mes, $año)
    {
        $fecha = Carbon::create($año, $mes, 28)->format('Y-m-d');
        
        // Asiento de provisión de aguinaldos
        $asiento1 = $this->crearAsiento($fecha, 'cierre_trimestral');
        $montoAguinaldo = rand(5000, 15000);
        
        DetalleAsiento::create([
            'asiento_id' => $asiento1->id,
            'cuenta_analitica_id' => $this->obtenerCuenta('aguinaldos'),
            'debe' => $montoAguinaldo,
            'haber' => 0,
            'glosa' => 'Provisión para aguinaldos trimestral',
        ]);
        
        DetalleAsiento::create([
            'asiento_id' => $asiento1->id,
            'cuenta_analitica_id' => $this->obtenerCuenta('provision_aguinaldos'),
            'debe' => 0,
            'haber' => $montoAguinaldo,
            'glosa' => 'Aguinaldos por pagar',
        ]);
        
        // Asiento de provisión de impuestos
        $asiento2 = $this->crearAsiento($fecha, 'cierre_trimestral');
        $montoImpuestos = rand(3000, 10000);
        
        DetalleAsiento::create([
            'asiento_id' => $asiento2->id,
            'cuenta_analitica_id' => $this->obtenerCuenta('impuestos'),
            'debe' => $montoImpuestos,
            'haber' => 0,
            'glosa' => 'Provisión para IUE trimestral',
        ]);
        
        DetalleAsiento::create([
            'asiento_id' => $asiento2->id,
            'cuenta_analitica_id' => $this->obtenerCuenta('impuestos_por_pagar'),
            'debe' => 0,
            'haber' => $montoImpuestos,
            'glosa' => 'Impuestos por pagar',
        ]);
    }
    
    private function crearAsientosCierreAnual($año)
    {
        $fecha = Carbon::create($año, 12, 31)->format('Y-m-d');
        
        // Asiento de regularización de inventario
        $asiento1 = $this->crearAsiento($fecha, 'cierre_anual');
        $montoInventario = rand(10000, 50000);
        
        DetalleAsiento::create([
            'asiento_id' => $asiento1->id,
            'cuenta_analitica_id' => $this->obtenerCuenta('inventario'),
            'debe' => $montoInventario,
            'haber' => 0,
            'glosa' => 'Ajuste de inventario final',
        ]);
        
        DetalleAsiento::create([
            'asiento_id' => $asiento1->id,
            'cuenta_analitica_id' => $this->obtenerCuenta('costo_ventas'),
            'debe' => 0,
            'haber' => $montoInventario,
            'glosa' => 'Costo de ventas',
        ]);
        
        // Asiento de resultado del ejercicio
        $asiento2 = $this->crearAsiento($fecha, 'cierre_anual');
        $utilidad = rand(20000, 80000);
        
        DetalleAsiento::create([
            'asiento_id' => $asiento2->id,
            'cuenta_analitica_id' => $this->obtenerCuenta('resultado_ejercicio'),
            'debe' => $utilidad,
            'haber' => 0,
            'glosa' => 'Utilidad del ejercicio ' . $año,
        ]);
        
        DetalleAsiento::create([
            'asiento_id' => $asiento2->id,
            'cuenta_analitica_id' => $this->obtenerCuenta('resultados_acumulados'),
            'debe' => 0,
            'haber' => $utilidad,
            'glosa' => 'Transferencia a resultados acumulados',
        ]);
    }
    
    private function obtenerCuentaAleatoria($tipo)
    {
        if (!empty($this->cuentasPorTipo[$tipo])) {
            return $this->cuentasPorTipo[$tipo][array_rand($this->cuentasPorTipo[$tipo])];
        }
        
        // Si no encuentra el tipo específico, devuelve cualquier cuenta
        return CuentaAnalitica::inRandomOrder()->first()->id;
    }
    
    private function obtenerCuenta($tipoEspecifico)
    {
        $mapaCuentas = [
            'iva' => $this->buscarCuentaPorNombre('CRÉDITO FISCAL IVA'),
            'iva_debito' => $this->buscarCuentaPorNombre('DÉBITO FISCAL - IVA'),
            'cargas_sociales' => $this->buscarCuentaPorNombre('CARGAS SOCIALES'),
            'gastos_generales' => $this->buscarCuentaPorNombre('GASTOS GENERALES'),
            'depreciacion_acumulada' => $this->buscarCuentaPorNombre('DEPRECIACIÓN ACUMULADA'),
            'costo_ventas' => $this->buscarCuentaPorNombre('COSTO DE VENTAS'),
            'gastos_financieros' => $this->buscarCuentaPorNombre('GASTOS FINANCIEROS'),
            'aguinaldos' => $this->buscarCuentaPorNombre('AGUINALDOS'),
            'provision_aguinaldos' => $this->buscarCuentaPorNombre('PROVISIÓN AGUINALDOS'),
            'impuestos' => $this->buscarCuentaPorNombre('IMPUESTOS'),
            'impuestos_por_pagar' => $this->buscarCuentaPorNombre('IMPUESTOS POR PAGAR'),
            'inventario' => $this->buscarCuentaPorNombre('INVENTARIO'),
            'resultado_ejercicio' => $this->buscarCuentaPorNombre('RESULTADO DE LA GESTIÓN'),
            'resultados_acumulados' => $this->buscarCuentaPorNombre('RESULTADOS ACUMULADOS'),
        ];
        
        return $mapaCuentas[$tipoEspecifico] ?? CuentaAnalitica::inRandomOrder()->first()->id;
    }
    
    private function buscarCuentaPorNombre($nombre)
    {
        $cuenta = CuentaAnalitica::where('nombre', 'like', '%' . $nombre . '%')->first();
        return $cuenta ? $cuenta->id : CuentaAnalitica::inRandomOrder()->first()->id;
    }
    
    private function verificarBalance($asientoId)
    {
        $suma = DetalleAsiento::where('asiento_id', $asientoId)
            ->selectRaw('SUM(debe) as total_debe, SUM(haber) as total_haber')
            ->first();
        
        $diferencia = abs($suma->total_debe - $suma->total_haber);
        
        if ($diferencia > 0.01) {
            $this->command->warn("⚠️  Asiento $asientoId no balanceado: diferencia = " . round($diferencia, 2));
            
            // Auto-corregir si la diferencia es pequeña
            if ($diferencia < 10) {
                $this->corregirBalance($asientoId, $suma->total_debe, $suma->total_haber);
            }
        }
    }
    
    private function corregirBalance($asientoId, $totalDebe, $totalHaber)
    {
        $diferencia = round($totalDebe - $totalHaber, 2);
        
        if (abs($diferencia) > 0.01) {
            $cuentaAjuste = CuentaAnalitica::where('nombre', 'like', '%DIVERSOS%')
                ->orWhere('nombre', 'like', '%AJUSTE%')
                ->first() ?? CuentaAnalitica::first();
            
            DetalleAsiento::create([
                'asiento_id' => $asientoId,
                'cuenta_analitica_id' => $cuentaAjuste->id,
                'debe' => $diferencia < 0 ? abs($diferencia) : 0,
                'haber' => $diferencia > 0 ? $diferencia : 0,
                'glosa' => 'Ajuste automático de balance',
            ]);
            
            $this->command->info("✅ Asiento $asientoId balanceado automáticamente");
        }
    }
    
    private function mostrarEstadisticas()
    {
        $this->command->info("\n📊 ESTADÍSTICAS DETALLADAS:");
        
        // Total asientos
        $totalAsientos = Asiento::count();
        $this->command->info("Total asientos en sistema: $totalAsientos");
        
        // Distribución por tipo de asiento
        $this->command->info("\n📅 DISTRIBUCIÓN POR MES Y AÑO:");
        $distribucion = Asiento::select(
            DB::raw('YEAR(fecha) as año'),
            DB::raw('MONTH(fecha) as mes'),
            DB::raw('COUNT(*) as cantidad')
        )
        ->groupBy(DB::raw('YEAR(fecha), MONTH(fecha)'))
        ->orderBy('año', 'desc')
        ->orderBy('mes', 'desc')
        ->get();
        
        foreach ($distribucion as $item) {
            $mesNombre = Carbon::create($item->año, $item->mes, 1)->locale('es')->monthName;
            $this->command->info("  {$mesNombre} {$item->año}: {$item->cantidad} asientos");
        }
        
        // Montos totales
        $montos = DetalleAsiento::select(
            DB::raw('SUM(debe) as total_debe'),
            DB::raw('SUM(haber) as total_haber')
        )->first();
        
        $this->command->info("\n💰 MONTOS ACUMULADOS:");
        $this->command->info("Total Debe: Bs. " . number_format($montos->total_debe, 2));
        $this->command->info("Total Haber: Bs. " . number_format($montos->total_haber, 2));
        
        $diferencia = $montos->total_debe - $montos->total_haber;
        if (abs($diferencia) < 0.01) {
            $this->command->info("✅ Sistema perfectamente balanceado");
        } else {
            $this->command->warn("⚠️  Diferencia: Bs. " . number_format($diferencia, 2));
        }
        
        // Top cuentas más utilizadas
        $this->command->info("\n🏆 TOP 10 CUENTAS MÁS UTILIZADAS:");
        $topCuentas = DetalleAsiento::select(
            'cuenta_analitica_id',
            DB::raw('COUNT(*) as usos'),
            DB::raw('SUM(debe) as total_debe'),
            DB::raw('SUM(haber) as total_haber')
        )
        ->with('cuentaAnalitica')
        ->groupBy('cuenta_analitica_id')
        ->orderBy('usos', 'desc')
        ->limit(10)
        ->get();
        
        foreach ($topCuentas as $index => $cuenta) {
            $nombre = $cuenta->cuentaAnalitica->nombre ?? 'Cuenta ' . $cuenta->cuenta_analitica_id;
            $this->command->info("  " . ($index + 1) . ". $nombre: {$cuenta->usos} usos");
        }
    }
}