<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubgruposSeeder extends Seeder
{
    public function run()
    {
        $subgrupos = [
            // ACTIVOS CORRIENTES (11)
            ['codigo' => '111', 'nombre' => 'EFECTIVO Y EQUIVALENTES DE EFECTIVO', 'grupo_id' => 1],
            ['codigo' => '112', 'nombre' => 'CUENTAS POR COBRAR', 'grupo_id' => 1],
            ['codigo' => '113', 'nombre' => 'INVENTARIOS', 'grupo_id' => 1],
            ['codigo' => '114', 'nombre' => 'OTROS ACTIVOS CORRIENTES', 'grupo_id' => 1],
            
            // ACTIVOS NO CORRIENTES (12)
            ['codigo' => '121', 'nombre' => 'CUENTAS POR COBRAR A LARGO PLAZO', 'grupo_id' => 2],
            ['codigo' => '122', 'nombre' => 'INVENTARIOS NO CORRIENTES', 'grupo_id' => 2],
            ['codigo' => '123', 'nombre' => 'PROPIEDAD PLANTA Y EQUIPO', 'grupo_id' => 2],
            ['codigo' => '124', 'nombre' => 'PROPIEDADES DE INVERSIÓN', 'grupo_id' => 2],
            ['codigo' => '125', 'nombre' => 'ACTIVOS INTANGIBLES', 'grupo_id' => 2],
            ['codigo' => '126', 'nombre' => 'INVERSIONES PERMANENTES', 'grupo_id' => 2],
            ['codigo' => '127', 'nombre' => 'ACTIVOS DIFERIDOS', 'grupo_id' => 2],
            ['codigo' => '128', 'nombre' => 'OTROS ACTIVOS NO CORRIENTES', 'grupo_id' => 2],
            
            // PASIVOS CORRIENTES (21)
            ['codigo' => '211', 'nombre' => 'OBLIGACIONES BANCARIAS Y FINANCIERAS', 'grupo_id' => 3],
            ['codigo' => '212', 'nombre' => 'CUENTAS POR PAGAR', 'grupo_id' => 3],
            ['codigo' => '213', 'nombre' => 'OBLIGACIONES SOCIALES Y FISCALES', 'grupo_id' => 3],
            ['codigo' => '214', 'nombre' => 'PROVISIONES', 'grupo_id' => 3],
            ['codigo' => '215', 'nombre' => 'INGRESOS DIFERIDOS', 'grupo_id' => 3],
            ['codigo' => '216', 'nombre' => 'OTROS PASIVOS CORRIENTES', 'grupo_id' => 3],
            
            // PASIVOS NO CORRIENTES (22)
            ['codigo' => '221', 'nombre' => 'OBLIGACIONES BANCARIAS Y FINANCIERAS A LARGO PLAZO', 'grupo_id' => 4],
            ['codigo' => '222', 'nombre' => 'CUENTAS POR PAGAR A LARGO PLAZO', 'grupo_id' => 4],
            ['codigo' => '223', 'nombre' => 'PREVISIÓN PARA BENEFICIOS SOCIALES', 'grupo_id' => 4],
            ['codigo' => '224', 'nombre' => 'OTROS PASIVOS NO CORRIENTES', 'grupo_id' => 4],
            
            // PATRIMONIO - CAPITAL (31)
            ['codigo' => '311', 'nombre' => 'CUENTAS DE CAPITAL', 'grupo_id' => 5],
            ['codigo' => '312', 'nombre' => 'AJUSTE DE CAPITAL', 'grupo_id' => 5],
            
            // PATRIMONIO - RESERVAS (32)
            ['codigo' => '321', 'nombre' => 'CUENTAS RESERVAS', 'grupo_id' => 6],
            ['codigo' => '322', 'nombre' => 'AJUSTE DE RESERVAS PATRIMONIALES', 'grupo_id' => 6],
            
            // PATRIMONIO - RESULTADOS ACUMULADOS (33)
            ['codigo' => '331', 'nombre' => 'CUENTAS DE RESULTADO', 'grupo_id' => 7],
            ['codigo' => '332', 'nombre' => 'ACTUALIZACION VALOR CUENTAS DE RESULTADOS', 'grupo_id' => 7],
            
            // INGRESOS NETOS (41)
            ['codigo' => '410', 'nombre' => 'INGRESOS NETOS', 'grupo_id' => 8],
            
            // INGRESOS FINANCIEROS (42)
            ['codigo' => '420', 'nombre' => 'INGRESOS FINANCIEROS', 'grupo_id' => 9],
            
            // OTROS INGRESOS (43)
            ['codigo' => '430', 'nombre' => 'OTROS INGRESOS', 'grupo_id' => 10],
            
            // COSTO DE VENTAS (51)
            ['codigo' => '510', 'nombre' => 'COSTO DE VENTAS', 'grupo_id' => 11],
            
            // GASTOS DE COMERCIALIZACIÓN (52)
            ['codigo' => '520', 'nombre' => 'GASTOS DE COMERCIALIZACIÓN', 'grupo_id' => 12],
            
            // GASTOS GENERALES DE ADMINISTRACIÓN (53)
            ['codigo' => '530', 'nombre' => 'GASTOS GENERALES DE ADMINISTRACIÓN', 'grupo_id' => 13],
            
            // GASTOS FINANCIEROS (54)
            ['codigo' => '540', 'nombre' => 'GASTOS FINANCIEROS', 'grupo_id' => 14],
            
            // OTROS GASTOS DE OPERACIÓN (55)
            ['codigo' => '550', 'nombre' => 'OTROS GASTOS DE OPERACIÓN', 'grupo_id' => 15],
            
            // OTROS GASTOS NO OPERATIVOS (56)
            ['codigo' => '560', 'nombre' => 'OTROS GASTOS NO OPERATIVOS', 'grupo_id' => 16],
            
            // IMPUESTO SOBRE LAS UTILIDADES (57)
            ['codigo' => '570', 'nombre' => 'IMPUESTO SOBRE LAS UTILIDADES DE LAS EMPRESAS', 'grupo_id' => 17],
        ];

        DB::table('subgrupos')->insert($subgrupos);
    }
}