<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->insertOrIgnore([
            'nombre'        => 'Fanny Alemán',
            'email'         => 'fannyaleman0312@gmail.com',
            'password_hash' => Hash::make(env('ADMIN_DEFAULT_PASSWORD', 'cambiar-esto')),
            'creado_en'     => now(),
        ]);
    }
}