<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            [
                'nombre'       => 'Ramo de Rosas Rojas',
                'descripcion'  => '12 rosas rojas de tallo largo, perfectas para expresar amor.',
                'precio'       => 18500,
                'categoria_id' => 1,
                'stock'        => 15,
                'destacado'    => true,
                'activo'       => true,
                'creado_en'    => now(),
            ],
            [
                'nombre'       => 'Arreglo Tropical',
                'descripcion'  => 'Mixto de flores tropicales con heliconias y aves del paraíso.',
                'precio'       => 22000,
                'categoria_id' => 2,
                'stock'        => 8,
                'destacado'    => true,
                'activo'       => true,
                'creado_en'    => now(),
            ],
            [
                'nombre'       => 'Planta Orquídea',
                'descripcion'  => 'Orquídea blanca en maceta decorativa, ideal para interiores.',
                'precio'       => 14500,
                'categoria_id' => 3,
                'stock'        => 10,
                'destacado'    => true,
                'activo'       => true,
                'creado_en'    => now(),
            ],
            [
                'nombre'       => 'Ramo Primaveral',
                'descripcion'  => 'Mezcla colorida de girasoles, margaritas y rosas frescas.',
                'precio'       => 16000,
                'categoria_id' => 1,
                'stock'        => 12,
                'destacado'    => false,
                'activo'       => true,
                'creado_en'    => now(),
            ],
            [
                'nombre'       => 'Arreglo de Bodas',
                'descripcion'  => 'Diseño elegante pensado para decoraciones nupciales.',
                'precio'       => 45000,
                'categoria_id' => 4,
                'stock'        => 5,
                'destacado'    => true,
                'activo'       => true,
                'creado_en'    => now(),
            ],
            [
                'nombre'       => 'Girasoles Frescos',
                'descripcion'  => 'Ramo de 10 girasoles frescos traídos directamente de la finca.',
                'precio'       => 13500,
                'categoria_id' => 1,
                'stock'        => 20,
                'destacado'    => false,
                'activo'       => true,
                'creado_en'    => now(),
            ],
            [
                'nombre'       => 'Flores Exóticas Mix',
                'descripcion'  => 'Selección de flores exóticas tropicales de temporada.',
                'precio'       => 28000,
                'categoria_id' => 5,
                'stock'        => 6,
                'destacado'    => true,
                'activo'       => true,
                'creado_en'    => now(),
            ],
            [
                'nombre'       => 'Centro de Mesa',
                'descripcion'  => 'Arreglo compacto ideal para centros de mesa en eventos.',
                'precio'       => 19500,
                'categoria_id' => 4,
                'stock'        => 8,
                'destacado'    => false,
                'activo'       => true,
                'creado_en'    => now(),
            ],
            [
                'nombre'       => 'Ramo de Lavanda',
                'descripcion'  => 'Lavanda seca decorativa con fragancia natural duradera.',
                'precio'       => 9500,
                'categoria_id' => 1,
                'stock'        => 25,
                'destacado'    => false,
                'activo'       => true,
                'creado_en'    => now(),
            ],
            [
                'nombre'       => 'Planta Suculenta Set',
                'descripcion'  => 'Set de 3 suculentas en macetas de barro artesanales costarricenses.',
                'precio'       => 12000,
                'categoria_id' => 3,
                'stock'        => 18,
                'destacado'    => false,
                'activo'       => true,
                'creado_en'    => now(),
            ],
        ];

        DB::table('productos')->insertOrIgnore($productos);
    }
}