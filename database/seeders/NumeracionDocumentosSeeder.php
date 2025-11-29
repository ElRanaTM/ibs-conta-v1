<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NumeracionDocumentosSeeder extends Seeder {
    public function run(): void {
        DB::table('numeracion_documentos')->insert([
            [
                'tipo_documento' => 'Pago',
                'serie' => 'PAG',
                'descripcion' => 'Comprobantes de Pago de Alumnos',
                'ultimo_numero' => 0,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_documento' => 'Egreso',
                'serie' => 'EGR',
                'descripcion' => 'Comprobantes de Egresos',
                'ultimo_numero' => 0,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_documento' => 'Asiento',
                'serie' => 'ASI',
                'descripcion' => 'Asientos Contables',
                'ultimo_numero' => 0,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}