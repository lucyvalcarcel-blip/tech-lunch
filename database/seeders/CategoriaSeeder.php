<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Desayunos', 'descripcion' => 'Sándwiches y tamales para empezar el día.', 'icono' => 'bi-cup-hot'],
            ['nombre' => 'Almuerzos', 'descripcion' => 'Menú del día y platos a la carta.', 'icono' => 'bi-egg-fried'],
            ['nombre' => 'Bebidas', 'descripcion' => 'Bebidas frías y calientes.', 'icono' => 'bi-cup-straw'],
            ['nombre' => 'Snacks', 'descripcion' => 'Dulces y bocaditos para el break.', 'icono' => 'bi-basket2'],
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->insert([
                'nombre' => $categoria['nombre'],
                'descripcion' => $categoria['descripcion'],
                'icono' => $categoria['icono'],
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}