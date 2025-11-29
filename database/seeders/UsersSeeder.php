<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Omar',
                'email' => 'omar@ibs.com',
                'password' => Hash::make('123456'),
                'role_id' => 1,
                'estado' => 'activo'
            ],
            [
                'name' => 'Marisol',
                'email' => 'marisol@ibs.com',
                'password' => Hash::make('123456'),
                'role_id' => 2,
                'estado' => 'activo'
            ],
            [
                'name' => 'David',
                'email' => 'david@ibs.com',
                'password' => Hash::make('123456'),
                'role_id' => 1,
                'estado' => 'activo'
            ],
        ]);
    }
}
