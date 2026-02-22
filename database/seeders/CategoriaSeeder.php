<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'id'          => 1,
                'nombre'      => 'Ramos',
                'descripcion' => 'Hermosos ramos para regalar en cualquier ocasión',
            ],
            [
                'id'          => 2,
                'nombre'      => 'Arreglos florales',
                'descripcion' => 'Arreglos únicos para toda ocasión',
            ],
            [
                'id'          => 3,
                'nombre'      => 'Plantas',
                'descripcion' => 'Plantas de interior y exterior',
            ],
            [
                'id'          => 4,
                'nombre'      => 'Flores para eventos',
                'descripcion' => 'Decoración floral para bodas y eventos especiales',
            ],
            [
                'id'          => 5,
                'nombre'      => 'Flores exóticas',
                'descripcion' => 'Flores tropicales y exóticas de temporada',
            ],
        ];

        DB::table('categorias')->insertOrIgnore($categorias);
    }
}