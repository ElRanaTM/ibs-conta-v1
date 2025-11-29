<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GruposSeeder extends Seeder
{
    public function run()
    {
        $grupos = [
            // ACTIVOS (1)
            ['codigo' => '11', 'nombre' => 'ACTIVOS CORRIENTES', 'clase_id' => 1],
            ['codigo' => '12', 'nombre' => 'ACTIVOS NO CORRIENTES', 'clase_id' => 1],
            
            // PASIVOS (2)
            ['codigo' => '21', 'nombre' => 'PASIVOS CORRIENTES', 'clase_id' => 2],
            ['codigo' => '22', 'nombre' => 'PASIVOS NO CORRIENTES', 'clase_id' => 2],
            
            // PATRIMONIO (3)
            ['codigo' => '31', 'nombre' => 'CAPITAL', 'clase_id' => 3],
            ['codigo' => '32', 'nombre' => 'RESERVAS', 'clase_id' => 3],
            ['codigo' => '33', 'nombre' => 'RESULTADOS ACUMULADOS', 'clase_id' => 3],
            
            // INGRESOS (4)
            ['codigo' => '41', 'nombre' => 'INGRESOS NETOS', 'clase_id' => 4],
            ['codigo' => '42', 'nombre' => 'INGRESOS FINANCIEROS', 'clase_id' => 4],
            ['codigo' => '43', 'nombre' => 'OTROS INGRESOS', 'clase_id' => 4],
            
            // COSTOS Y GASTOS (5)
            ['codigo' => '51', 'nombre' => 'COSTO DE VENTAS', 'clase_id' => 5],
            ['codigo' => '52', 'nombre' => 'GASTOS DE COMERCIALIZACIÓN', 'clase_id' => 5],
            ['codigo' => '53', 'nombre' => 'GASTOS GENERALES DE ADMINISTRACIÓN', 'clase_id' => 5],
            ['codigo' => '54', 'nombre' => 'GASTOS FINANCIEROS', 'clase_id' => 5],
            ['codigo' => '55', 'nombre' => 'OTROS GASTOS DE OPERACIÓN', 'clase_id' => 5],
            ['codigo' => '56', 'nombre' => 'OTROS GASTOS NO OPERATIVOS', 'clase_id' => 5],
            ['codigo' => '57', 'nombre' => 'IMPUESTO SOBRE LAS UTILIDADES DE LAS EMPRESAS', 'clase_id' => 5],
        ];

        DB::table('grupos')->insert($grupos);
    }
}