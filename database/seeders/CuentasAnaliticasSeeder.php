<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CuentasAnaliticasSeeder extends Seeder
{
    public function run()
    {
        $cuentasAnaliticas = [
            // CAJA (111001)
            ['codigo' => '111001001', 'nombre' => 'CAJA MONEDA NACIONAL', 'cuenta_principal_id' => 1, 'es_auxiliar' => true],
            ['codigo' => '111001002', 'nombre' => 'CAJA MONEDA EXTRANJERA', 'cuenta_principal_id' => 1, 'es_auxiliar' => true],
            ['codigo' => '111001003', 'nombre' => 'CAJA CHICA', 'cuenta_principal_id' => 1, 'es_auxiliar' => true],
            
            // BANCOS (111003)
            ['codigo' => '111003001', 'nombre' => 'BANCO NACIONAL CUENTA CORRIENTE', 'cuenta_principal_id' => 3, 'es_auxiliar' => true],
            ['codigo' => '111003002', 'nombre' => 'BANCO EXTRANJERO CUENTA CORRIENTE', 'cuenta_principal_id' => 3, 'es_auxiliar' => true],
            ['codigo' => '111003003', 'nombre' => 'CUENTA DE AHORROS', 'cuenta_principal_id' => 3, 'es_auxiliar' => true],
            
            // CUENTAS POR COBRAR COMERCIALES (112001)
            ['codigo' => '112001001', 'nombre' => 'CLIENTES NACIONALES', 'cuenta_principal_id' => 5, 'es_auxiliar' => true],
            ['codigo' => '112001002', 'nombre' => 'CLIENTES EXTRANJEROS', 'cuenta_principal_id' => 5, 'es_auxiliar' => true],
            ['codigo' => '112001003', 'nombre' => 'DEUDORES VARIOS', 'cuenta_principal_id' => 5, 'es_auxiliar' => true],
            
            // INVENTARIOS DE PRODUCTOS TERMINADOS (113001)
            ['codigo' => '113001001', 'nombre' => 'PRODUCTOS TERMINADOS ZAPATOS', 'cuenta_principal_id' => 10, 'es_auxiliar' => true],
            ['codigo' => '113001002', 'nombre' => 'PRODUCTOS TERMINADOS CALZADO DEPORTIVO', 'cuenta_principal_id' => 10, 'es_auxiliar' => true],
            
            // INVENTARIOS DE MATERIA PRIMA (113003)
            ['codigo' => '113003001', 'nombre' => 'MATERIA PRIMA CUERO', 'cuenta_principal_id' => 12, 'es_auxiliar' => true],
            ['codigo' => '113003002', 'nombre' => 'MATERIA PRIMA SUELA', 'cuenta_principal_id' => 12, 'es_auxiliar' => true],
            ['codigo' => '113003003', 'nombre' => 'MATERIA PRIMA HILOS', 'cuenta_principal_id' => 12, 'es_auxiliar' => true],
            
            // CRÉDITO FISCAL IVA (114001)
            ['codigo' => '114001001', 'nombre' => 'CRÉDITO FISCAL IVA COMPRAS', 'cuenta_principal_id' => 16, 'es_auxiliar' => true],
            ['codigo' => '114001002', 'nombre' => 'CRÉDITO FISCAL IVA SERVICIOS', 'cuenta_principal_id' => 16, 'es_auxiliar' => true],
            
            // TERRENOS (123001)
            ['codigo' => '123001001', 'nombre' => 'TERRENO PLANTA INDUSTRIAL', 'cuenta_principal_id' => 20, 'es_auxiliar' => true],
            ['codigo' => '123001002', 'nombre' => 'TERRENO OFICINAS ADMINISTRATIVAS', 'cuenta_principal_id' => 20, 'es_auxiliar' => true],
            
            // EDIFICIOS (123002)
            ['codigo' => '123002001', 'nombre' => 'EDIFICIO PLANTA INDUSTRIAL', 'cuenta_principal_id' => 21, 'es_auxiliar' => true],
            ['codigo' => '123002002', 'nombre' => 'EDIFICIO OFICINAS ADMINISTRATIVAS', 'cuenta_principal_id' => 21, 'es_auxiliar' => true],
            
            // MAQUINARIAS (123004)
            ['codigo' => '123004001', 'nombre' => 'MAQUINARIA CORTE CUERO', 'cuenta_principal_id' => 23, 'es_auxiliar' => true],
            ['codigo' => '123004002', 'nombre' => 'MAQUINARIA COSTURA', 'cuenta_principal_id' => 23, 'es_auxiliar' => true],
            ['codigo' => '123004003', 'nombre' => 'MAQUINARIA ENSAMBLAJE', 'cuenta_principal_id' => 23, 'es_auxiliar' => true],
            
            // VEHÍCULOS (123006)
            ['codigo' => '123006001', 'nombre' => 'VEHÍCULO REPARTO', 'cuenta_principal_id' => 25, 'es_auxiliar' => true],
            ['codigo' => '123006002', 'nombre' => 'VEHÍCULO ADMINISTRATIVO', 'cuenta_principal_id' => 25, 'es_auxiliar' => true],
            
            // MUEBLES Y ENSERES (123008)
            ['codigo' => '123008001', 'nombre' => 'MUEBLES OFICINA', 'cuenta_principal_id' => 27, 'es_auxiliar' => true],
            ['codigo' => '123008002', 'nombre' => 'EQUIPOS DE OFICINA', 'cuenta_principal_id' => 27, 'es_auxiliar' => true],
            
            // EQUIPOS DE COMPUTACIÓN (123010)
            ['codigo' => '123010001', 'nombre' => 'COMPUTADORAS ESCRITORIO', 'cuenta_principal_id' => 29, 'es_auxiliar' => true],
            ['codigo' => '123010002', 'nombre' => 'LAPTOPS', 'cuenta_principal_id' => 29, 'es_auxiliar' => true],
            ['codigo' => '123010003', 'nombre' => 'SERVIDORES', 'cuenta_principal_id' => 29, 'es_auxiliar' => true],
            
            // PATENTES Y MARCAS (125001)
            ['codigo' => '125001001', 'nombre' => 'MARCA REGISTRADA ZAPATOS "BOLISUELA"', 'cuenta_principal_id' => 33, 'es_auxiliar' => true],
            ['codigo' => '125001002', 'nombre' => 'PATENTE PROCESO FABRICACIÓN', 'cuenta_principal_id' => 33, 'es_auxiliar' => true],
            
            // PRÉSTAMOS BANCARIOS (211001)
            ['codigo' => '211001001', 'nombre' => 'PRÉSTAMO BANCARIO CORTO PLAZO BNB', 'cuenta_principal_id' => 36, 'es_auxiliar' => true],
            ['codigo' => '211001002', 'nombre' => 'PRÉSTAMO BANCARIO CORTO PLAZO BCP', 'cuenta_principal_id' => 36, 'es_auxiliar' => true],
            
            // CUENTAS POR PAGAR COMERCIALES (212001)
            ['codigo' => '212001001', 'nombre' => 'PROVEEDORES NACIONALES', 'cuenta_principal_id' => 38, 'es_auxiliar' => true],
            ['codigo' => '212001002', 'nombre' => 'PROVEEDORES EXTRANJEROS', 'cuenta_principal_id' => 38, 'es_auxiliar' => true],
            
            // SUELDOS POR PAGAR (213001)
            ['codigo' => '213001001', 'nombre' => 'SUELDOS ADMINISTRATIVOS POR PAGAR', 'cuenta_principal_id' => 40, 'es_auxiliar' => true],
            ['codigo' => '213001002', 'nombre' => 'SUELDOS PRODUCCIÓN POR PAGAR', 'cuenta_principal_id' => 40, 'es_auxiliar' => true],
            ['codigo' => '213001003', 'nombre' => 'SUELDOS COMERCIALES POR PAGAR', 'cuenta_principal_id' => 40, 'es_auxiliar' => true],
            
            // CAPITAL SOCIAL PAGADO (311001)
            ['codigo' => '311001001', 'nombre' => 'CAPITAL SOCIAL PAGADO ACCIONISTAS', 'cuenta_principal_id' => 50, 'es_auxiliar' => true],
            
            // VENTAS (410001)
            ['codigo' => '410001001', 'nombre' => 'VENTAS ZAPATOS NACIONAL', 'cuenta_principal_id' => 55, 'es_auxiliar' => true],
            ['codigo' => '410001002', 'nombre' => 'VENTAS ZAPATOS EXPORTACIÓN', 'cuenta_principal_id' => 55, 'es_auxiliar' => true],
            ['codigo' => '410001003', 'nombre' => 'VENTAS CALZADO DEPORTIVO', 'cuenta_principal_id' => 55, 'es_auxiliar' => true],
            
            // COSTO DE PRODUCTOS (510001)
            ['codigo' => '510001001', 'nombre' => 'COSTO MATERIA PRIMA ZAPATOS', 'cuenta_principal_id' => 57, 'es_auxiliar' => true],
            ['codigo' => '510001002', 'nombre' => 'COSTO MANO OBRA ZAPATOS', 'cuenta_principal_id' => 57, 'es_auxiliar' => true],
            ['codigo' => '510001003', 'nombre' => 'COSTOS INDIRECTOS FABRICACIÓN', 'cuenta_principal_id' => 57, 'es_auxiliar' => true],
            
            // SUELDOS Y SALARIOS ADMINISTRATIVOS (530001)
            ['codigo' => '530001001', 'nombre' => 'SUELDOS GERENCIA', 'cuenta_principal_id' => 72, 'es_auxiliar' => true],
            ['codigo' => '530001002', 'nombre' => 'SUELDOS ADMINISTRATIVOS', 'cuenta_principal_id' => 72, 'es_auxiliar' => true],
            ['codigo' => '530001003', 'nombre' => 'SUELDOS CONTABILIDAD', 'cuenta_principal_id' => 72, 'es_auxiliar' => true],
            
            // SUELDOS Y SALARIOS COMERCIALES (520001)
            ['codigo' => '520001001', 'nombre' => 'SUELDOS VENDEDORES', 'cuenta_principal_id' => 65, 'es_auxiliar' => true],
            ['codigo' => '520001002', 'nombre' => 'SUELDOS SUPERVISORES VENTAS', 'cuenta_principal_id' => 65, 'es_auxiliar' => true],
        ];

        DB::table('cuentas_analiticas')->insert($cuentasAnaliticas);
    }
}