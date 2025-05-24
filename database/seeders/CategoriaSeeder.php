<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Platos Fuertes',
            'Bebidas',
            'Postres',
            'Entradas',
            'Sopas',
            'Ensaladas',
            'Guarniciones',
            'Combos',
            'Menú Infantil',
            'Insumos (Cocina)'
        ];

        foreach ($categorias as $nombre) {
            Categoria::create([
                'nombre' => $nombre,
                'descripcion' => 'Categoría creada automáticamente: ' . $nombre,
            ]);
        }
    }
}
