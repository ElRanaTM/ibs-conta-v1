<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonedaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('moneda')->insert([
            [
                'nombre' => 'Boliviano',
                'abreviatura' => 'BOB',
                'simbolo' => 'Bs.',
                'es_local' => true
            ],
            [
                'nombre' => 'Dólar Americano',
                'abreviatura' => 'USD',
                'simbolo' => '$',
                'es_local' => false
            ],
            [
                'nombre' => 'Euro',
                'abreviatura' => 'EUR',
                'simbolo' => '€',
                'es_local' => false
            ],
        ]);
    }
}
