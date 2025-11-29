<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CuentasPrincipalesSeeder extends Seeder
{
    public function run()
    {
        $cuentas = [
            // EFECTIVO Y EQUIVALENTES (111)
            ['codigo' => '111001', 'nombre' => 'CAJA', 'subgrupo_id' => 1],
            ['codigo' => '111002', 'nombre' => 'FONDO FIJO', 'subgrupo_id' => 1],
            ['codigo' => '111003', 'nombre' => 'BANCOS', 'subgrupo_id' => 1],
            ['codigo' => '111004', 'nombre' => 'INVERSIONES TEMPORALES', 'subgrupo_id' => 1],
            
            // CUENTAS POR COBRAR (112)
            ['codigo' => '112001', 'nombre' => 'CUENTAS POR COBRAR COMERCIALES', 'subgrupo_id' => 2],
            ['codigo' => '112002', 'nombre' => 'OTRAS CUENTAS POR COBRAR', 'subgrupo_id' => 2],
            ['codigo' => '112003', 'nombre' => 'CUENTAS POR COBRAR A EMPRESAS RELACIONADAS', 'subgrupo_id' => 2],
            ['codigo' => '112004', 'nombre' => 'ANTICIPO A PROVEEDORES', 'subgrupo_id' => 2],
            ['codigo' => '112005', 'nombre' => 'PROVISIÓN PARA CUENTAS INCOBRABLES', 'subgrupo_id' => 2],
            
            // INVENTARIOS (113)
            ['codigo' => '113001', 'nombre' => 'INVENTARIOS DE PRODUCTOS TERMINADOS', 'subgrupo_id' => 3],
            ['codigo' => '113002', 'nombre' => 'INVENTARIOS DE PRODUCTOS EN PROCESO', 'subgrupo_id' => 3],
            ['codigo' => '113003', 'nombre' => 'INVENTARIOS DE MATERIA PRIMA', 'subgrupo_id' => 3],
            ['codigo' => '113004', 'nombre' => 'INVENTARIO EN TRÁNSITO', 'subgrupo_id' => 3],
            ['codigo' => '113005', 'nombre' => 'PROVISIÓN PARA OBSOLESCENCIAS', 'subgrupo_id' => 3],
            
            // OTROS ACTIVOS CORRIENTES (114)
            ['codigo' => '114001', 'nombre' => 'CRÉDITO FISCAL IVA', 'subgrupo_id' => 4],
            ['codigo' => '114002', 'nombre' => 'IMPUESTOS POR RECUPERAR', 'subgrupo_id' => 4],
            ['codigo' => '114003', 'nombre' => 'PAGOS ANTICIPADOS', 'subgrupo_id' => 4],
            ['codigo' => '114004', 'nombre' => 'OTROS ACTIVOS', 'subgrupo_id' => 4],
            
            // PROPIEDAD PLANTA Y EQUIPO (123)
            ['codigo' => '123001', 'nombre' => 'TERRENOS', 'subgrupo_id' => 7],
            ['codigo' => '123002', 'nombre' => 'EDIFICIOS', 'subgrupo_id' => 7],
            ['codigo' => '123003', 'nombre' => 'DEPRECIACIÓN ACUMULADA EDIFICIO', 'subgrupo_id' => 7],
            ['codigo' => '123004', 'nombre' => 'MAQUINARIAS', 'subgrupo_id' => 7],
            ['codigo' => '123005', 'nombre' => 'DEPRECIACIÓN ACUMULADA MAQUINARIAS', 'subgrupo_id' => 7],
            ['codigo' => '123006', 'nombre' => 'VEHÍCULOS', 'subgrupo_id' => 7],
            ['codigo' => '123007', 'nombre' => 'DEPRECIACIÓN ACUMULADA VEHÍCULOS', 'subgrupo_id' => 7],
            ['codigo' => '123008', 'nombre' => 'MUEBLES Y ENSERES', 'subgrupo_id' => 7],
            ['codigo' => '123009', 'nombre' => 'DEPRECIACIÓN ACUMULADA MUEBLES Y ENSERES', 'subgrupo_id' => 7],
            ['codigo' => '123010', 'nombre' => 'EQUIPOS DE COMPUTACIÓN', 'subgrupo_id' => 7],
            ['codigo' => '123011', 'nombre' => 'DEPRECIACIÓN ACUMULADA EQUIPOS DE COMPUTACIÓN', 'subgrupo_id' => 7],
            
            // ACTIVOS INTANGIBLES (125)
            ['codigo' => '125001', 'nombre' => 'PATENTES Y MARCAS', 'subgrupo_id' => 9],
            ['codigo' => '125002', 'nombre' => 'AMORTIZACIÓN ACUMULADA PATENTES Y MARCAS', 'subgrupo_id' => 9],
            ['codigo' => '125003', 'nombre' => 'DERECHOS DE LLAVE', 'subgrupo_id' => 9],
            ['codigo' => '125004', 'nombre' => 'AMORTIZACIÓN ACUMULADA DERECHO DE LLAVE', 'subgrupo_id' => 9],
            
            // OBLIGACIONES BANCARIAS Y FINANCIERAS (211)
            ['codigo' => '211001', 'nombre' => 'PRÉSTAMOS BANCARIOS', 'subgrupo_id' => 11],
            ['codigo' => '211002', 'nombre' => 'OTROS PASIVOS FINANCIEROS', 'subgrupo_id' => 11],
            ['codigo' => '211003', 'nombre' => 'INTERESES POR PAGAR', 'subgrupo_id' => 11],
            
            // CUENTAS POR PAGAR (212)
            ['codigo' => '212001', 'nombre' => 'CUENTAS POR PAGAR COMERCIALES', 'subgrupo_id' => 12],
            ['codigo' => '212002', 'nombre' => 'DOCUMENTOS POR PAGAR', 'subgrupo_id' => 12],
            ['codigo' => '212003', 'nombre' => 'CUENTAS POR PAGAR A EMPRESAS RELACIONADAS', 'subgrupo_id' => 12],
            
            // OBLIGACIONES SOCIALES Y FISCALES (213)
            ['codigo' => '213001', 'nombre' => 'SUELDOS POR PAGAR', 'subgrupo_id' => 13],
            ['codigo' => '213002', 'nombre' => 'BENEFICIOS SOCIALES POR PAGAR', 'subgrupo_id' => 13],
            ['codigo' => '213003', 'nombre' => 'CARGAS SOCIALES', 'subgrupo_id' => 13],
            ['codigo' => '213004', 'nombre' => 'DÉBITO FISCAL - IVA', 'subgrupo_id' => 13],
            ['codigo' => '213005', 'nombre' => 'IMPUESTO A LAS TRANSACCIONES POR PAGAR', 'subgrupo_id' => 13],
            ['codigo' => '213006', 'nombre' => 'IMPUESTOS SOBRE LAS UTILIDADES DE LAS EMPRESAS POR PAGAR', 'subgrupo_id' => 13],
            ['codigo' => '213007', 'nombre' => 'RETENCIONES POR PAGAR', 'subgrupo_id' => 13],
            ['codigo' => '213008', 'nombre' => 'OTROS IMPUESTOS POR PAGAR', 'subgrupo_id' => 13],
            
            // CAPITAL (311)
            ['codigo' => '311001', 'nombre' => 'CAPITAL SOCIAL PAGADO', 'subgrupo_id' => 23],
            ['codigo' => '311002', 'nombre' => 'APORTES POR CAPITALIZAR', 'subgrupo_id' => 23],
            ['codigo' => '311003', 'nombre' => 'AJUSTE DE CAPITAL', 'subgrupo_id' => 23],
            
            // RESERVAS (321)
            ['codigo' => '321001', 'nombre' => 'RESERVA LEGAL', 'subgrupo_id' => 25],
            ['codigo' => '321002', 'nombre' => 'OTRAS RESERVAS', 'subgrupo_id' => 25],
            ['codigo' => '321003', 'nombre' => 'AJUSTE DE RESERVAS PATRIMONIALES', 'subgrupo_id' => 25],
            
            // RESULTADOS ACUMULADOS (331)
            ['codigo' => '331001', 'nombre' => 'RESULTADOS ACUMULADOS', 'subgrupo_id' => 27],
            ['codigo' => '331002', 'nombre' => 'RESULTADO DE LA GESTIÓN', 'subgrupo_id' => 27],
            
            // INGRESOS NETOS (410)
            ['codigo' => '410001', 'nombre' => 'VENTAS', 'subgrupo_id' => 28],
            ['codigo' => '410002', 'nombre' => 'DEVOLUCIONES, REBAJAS Y DESCUENTOS DE BIENES Y/O SERVICIOS', 'subgrupo_id' => 28],
            
            // COSTO DE VENTAS (510)
            ['codigo' => '510001', 'nombre' => 'COSTO DE PRODUCTOS', 'subgrupo_id' => 29],
            ['codigo' => '510002', 'nombre' => 'FLETES Y TRANSPORTES DE PRODUCTOS', 'subgrupo_id' => 29],
            ['codigo' => '510003', 'nombre' => 'DEVOLUCIÓN EN COMPRAS', 'subgrupo_id' => 29],
            ['codigo' => '510004', 'nombre' => 'DESCUENTOS SOBRE COMPRAS', 'subgrupo_id' => 29],
            ['codigo' => '510005', 'nombre' => 'COSTO DE PRODUCTOS DAÑADOS', 'subgrupo_id' => 29],
            
            // GASTOS DE COMERCIALIZACIÓN (520)
            ['codigo' => '520001', 'nombre' => 'SUELDOS Y SALARIOS', 'subgrupo_id' => 30],
            ['codigo' => '520002', 'nombre' => 'BENEFICIOS SOCIALES', 'subgrupo_id' => 30],
            ['codigo' => '520003', 'nombre' => 'COMISIONES SOBRE VENTAS', 'subgrupo_id' => 30],
            ['codigo' => '520004', 'nombre' => 'VÍATICOS', 'subgrupo_id' => 30],
            ['codigo' => '520005', 'nombre' => 'PASAJES', 'subgrupo_id' => 30],
            ['codigo' => '520006', 'nombre' => 'PUBLICIDAD', 'subgrupo_id' => 30],
            ['codigo' => '520007', 'nombre' => 'DEPRECIACIÓN DE BIENES DE USO', 'subgrupo_id' => 30],
            ['codigo' => '520008', 'nombre' => 'PÉRDIDA EN CUENTAS INCOBRABLES', 'subgrupo_id' => 30],
            ['codigo' => '520009', 'nombre' => 'OTROS GASTOS DE COMERCIALIZACIÓN', 'subgrupo_id' => 30],
            
            // GASTOS GENERALES DE ADMINISTRACIÓN (530)
            ['codigo' => '530001', 'nombre' => 'SUELDOS Y SALARIOS', 'subgrupo_id' => 31],
            ['codigo' => '530002', 'nombre' => 'BENEFICIOS SOCIALES', 'subgrupo_id' => 31],
            ['codigo' => '530003', 'nombre' => 'PROVISIÓN AGUINALDOS', 'subgrupo_id' => 31],
            ['codigo' => '530004', 'nombre' => 'PREVISIÓN INDEMNIZACIONES', 'subgrupo_id' => 31],
            ['codigo' => '530005', 'nombre' => 'VÍATICOS', 'subgrupo_id' => 31],
            ['codigo' => '530006', 'nombre' => 'PASAJES', 'subgrupo_id' => 31],
            ['codigo' => '530007', 'nombre' => 'SERVICIOS BÁSICOS', 'subgrupo_id' => 31],
            ['codigo' => '530008', 'nombre' => 'MATERIALES Y SUMINISTROS', 'subgrupo_id' => 31],
            ['codigo' => '530009', 'nombre' => 'FLETES Y TRANSPORTE', 'subgrupo_id' => 31],
            ['codigo' => '530010', 'nombre' => 'MANTENIMIENTO Y REPARACIÓN', 'subgrupo_id' => 31],
            ['codigo' => '530011', 'nombre' => 'DEPRECIACIÓN DE BIENES DE USO', 'subgrupo_id' => 31],
            ['codigo' => '530012', 'nombre' => 'ALQUILERES', 'subgrupo_id' => 31],
            ['codigo' => '530013', 'nombre' => 'SEGUROS', 'subgrupo_id' => 31],
            ['codigo' => '530014', 'nombre' => 'SERVICIO DE SEGURIDAD', 'subgrupo_id' => 31],
            ['codigo' => '530015', 'nombre' => 'GASTOS GENERALES', 'subgrupo_id' => 31],
            ['codigo' => '530016', 'nombre' => 'OTROS GASTOS DE ADMINISTRACIÓN', 'subgrupo_id' => 31],
            
            // GASTOS FINANCIEROS (540)
            ['codigo' => '540001', 'nombre' => 'INTERESES SOBRE PRÉSTAMOS BANCARIOS', 'subgrupo_id' => 32],
            ['codigo' => '540002', 'nombre' => 'INTERESES SOBRE OTRAS OBLIGACIONES FINANCIERAS', 'subgrupo_id' => 32],
            ['codigo' => '540003', 'nombre' => 'OTROS INTERESES', 'subgrupo_id' => 32],
            ['codigo' => '540004', 'nombre' => 'COMISIONES BANCARIAS', 'subgrupo_id' => 32],
            ['codigo' => '540005', 'nombre' => 'OTROS GASTOS FINANCIEROS', 'subgrupo_id' => 32],
            
            // INGRESOS FINANCIEROS (420)
            ['codigo' => '420001', 'nombre' => 'INTERESES SOBRE DEPÓSITOS BANCARIOS', 'subgrupo_id' => 29],
            ['codigo' => '420002', 'nombre' => 'INTERESES DE INVERSIONES TEMPORALES', 'subgrupo_id' => 29],
            ['codigo' => '420003', 'nombre' => 'OTROS INGRESOS FINANCIEROS', 'subgrupo_id' => 29],
            
            // OTROS INGRESOS (430)
            ['codigo' => '430001', 'nombre' => 'AJUSTE POR INFLACIÓN Y TENENCIA DE BIENES', 'subgrupo_id' => 30],
            ['codigo' => '430002', 'nombre' => 'INGRESOS POR VENTA DE VALORES', 'subgrupo_id' => 30],
            ['codigo' => '430003', 'nombre' => 'OTROS INGRESOS', 'subgrupo_id' => 30],
        ];

        DB::table('cuentas_principales')->insert($cuentas);
    }
}