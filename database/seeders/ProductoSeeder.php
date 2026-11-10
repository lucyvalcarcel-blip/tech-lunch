<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // id de cada categoría según su nombre: ['Desayunos' => 1, 'Almuerzos' => 2, ...]
        $categorias = DB::table('categorias')->pluck('id', 'nombre');

        $productos = [
            // Desayunos
            ['nombre' => 'Pan con chicharrón', 'categoria' => 'Desayunos', 'precio' => 7.00, 'stock' => 12, 'destacado' => true, 'estado' => true, 'descripcion' => 'Con camote frito y salsa criolla.'],
            ['nombre' => 'Butifarra', 'categoria' => 'Desayunos', 'precio' => 6.50, 'stock' => 8, 'destacado' => false, 'estado' => true, 'descripcion' => 'Jamón del país con sarsa de cebolla.'],
            ['nombre' => 'Pan con pollo', 'categoria' => 'Desayunos', 'precio' => 6.00, 'stock' => 3, 'destacado' => false, 'estado' => true, 'descripcion' => 'Pollo deshilachado con mayonesa.'],
            ['nombre' => 'Tamal con pan', 'categoria' => 'Desayunos', 'precio' => 6.00, 'stock' => 10, 'destacado' => false, 'estado' => true, 'descripcion' => 'Tamal de cerdo con salsa criolla.'],

            // Almuerzos
            ['nombre' => 'Menú del día', 'categoria' => 'Almuerzos', 'precio' => 10.00, 'stock' => 25, 'destacado' => true, 'estado' => true, 'descripcion' => 'Sopa + segundo + refresco.'],
            ['nombre' => 'Lomo saltado', 'categoria' => 'Almuerzos', 'precio' => 14.00, 'stock' => 9, 'destacado' => true, 'estado' => true, 'descripcion' => 'Con arroz y papas fritas.'],
            ['nombre' => 'Ají de gallina', 'categoria' => 'Almuerzos', 'precio' => 12.00, 'stock' => 6, 'destacado' => false, 'estado' => true, 'descripcion' => 'Con arroz, papa y huevo.'],
            ['nombre' => 'Pollo a la plancha', 'categoria' => 'Almuerzos', 'precio' => 13.00, 'stock' => 0, 'destacado' => false, 'estado' => true, 'descripcion' => 'Con ensalada y arroz.'],
            ['nombre' => 'Tallarines verdes', 'categoria' => 'Almuerzos', 'precio' => 12.00, 'stock' => 0, 'destacado' => false, 'estado' => false, 'descripcion' => 'Con bistec apanado. Temporalmente no disponible.'],

            // Bebidas
            ['nombre' => 'Café americano', 'categoria' => 'Bebidas', 'precio' => 3.50, 'stock' => 30, 'destacado' => false, 'estado' => true, 'descripcion' => 'Taza de 8 oz.'],
            ['nombre' => 'Chicha morada', 'categoria' => 'Bebidas', 'precio' => 3.00, 'stock' => 20, 'destacado' => true, 'estado' => true, 'descripcion' => 'Vaso de 500 ml.'],
            ['nombre' => 'Inca Kola', 'categoria' => 'Bebidas', 'precio' => 3.50, 'stock' => 15, 'destacado' => false, 'estado' => true, 'descripcion' => 'Botella de 500 ml.'],
            ['nombre' => 'Jugo de naranja', 'categoria' => 'Bebidas', 'precio' => 4.00, 'stock' => 4, 'destacado' => false, 'estado' => true, 'descripcion' => 'Natural, vaso de 400 ml.'],

            // Snacks
            ['nombre' => 'Empanada de carne', 'categoria' => 'Snacks', 'precio' => 4.00, 'stock' => 14, 'destacado' => false, 'estado' => true, 'descripcion' => 'Horneada, recién salida.'],
            ['nombre' => 'Keke de vainilla', 'categoria' => 'Snacks', 'precio' => 3.00, 'stock' => 10, 'destacado' => false, 'estado' => true, 'descripcion' => 'Porción individual.'],
            ['nombre' => 'Alfajor', 'categoria' => 'Snacks', 'precio' => 2.50, 'stock' => 0, 'destacado' => false, 'estado' => true, 'descripcion' => 'Con manjar blanco.'],
            ['nombre' => 'Galletas de avena', 'categoria' => 'Snacks', 'precio' => 2.00, 'stock' => 18, 'destacado' => false, 'estado' => true, 'descripcion' => 'Paquete de 3 unidades.'],
        ];

        foreach ($productos as $producto) {
            DB::table('productos')->insert([
                'nombre' => $producto['nombre'],
                'descripcion' => $producto['descripcion'],
                'precio' => $producto['precio'],
                'stock' => $producto['stock'],
                'imagen' => null,
                'destacado' => $producto['destacado'],
                'estado' => $producto['estado'],
                'categoria_id' => $categorias[$producto['categoria']],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}