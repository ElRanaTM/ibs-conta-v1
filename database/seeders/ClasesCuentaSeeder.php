<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasesCuentaSeeder extends Seeder
{
    public function run()
    {
        $clases = [
            ['codigo' => '1', 'nombre' => 'ACTIVOS'],
            ['codigo' => '2', 'nombre' => 'PASIVOS'],
            ['codigo' => '3', 'nombre' => 'PATRIMONIO'],
            ['codigo' => '4', 'nombre' => 'INGRESOS'],
            ['codigo' => '5', 'nombre' => 'COSTOS Y GASTOS'],
        ];

        DB::table('clases_cuenta')->insert($clases);
    }
}