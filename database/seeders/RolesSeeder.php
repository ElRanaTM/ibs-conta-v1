<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nombre' => 'admin','descripcion' => 'Administrador del sistema'],
            ['nombre' => 'contador','descripcion' => 'Contador del sistema'],
            ['nombre' => 'secretario','descripcion' => 'Secretario del sistema'],
        ]);
    }
}
