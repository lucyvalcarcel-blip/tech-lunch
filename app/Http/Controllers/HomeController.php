<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $pasos = [
            ['icono' => 'bi-hand-index-thumb', 'color' => 'satin-azul', 'titulo' => '1. Elige', 'texto' => 'Revisa el menú del día, las bebidas y los snacks, y agrégalos a tu carrito.'],
            ['icono' => 'bi-phone', 'color' => 'satin-amarillo', 'titulo' => '2. Paga', 'texto' => 'Paga con Yape o Plin y registra tu número de operación.'],
            ['icono' => 'bi-bag-check', 'color' => 'satin-azul', 'titulo' => '3. Recibe', 'texto' => 'Recógelo en el cafetín o recíbelo en tu pabellón y aula.'],
        ];

        $ofertas = [
            ['nombre' => 'Lomo saltado', 'descripcion' => 'Con arroz y papas fritas.', 'precio' => 11.20, 'precio_antes' => 14.00, 'etiqueta' => '-20%', 'icono' => 'bi-fire', 'clase' => 'img-almuerzo'],
            ['nombre' => 'Butifarra + café', 'descripcion' => 'Desayuno completo hasta las 10:00 a. m.', 'precio' => 8.00, 'precio_antes' => 10.00, 'etiqueta' => 'Combo', 'icono' => 'bi-cup-hot', 'clase' => 'img-desayuno'],
            ['nombre' => 'Empanada de carne', 'descripcion' => 'Lleva 2 y paga 1, solo por la tarde.', 'precio' => 4.00, 'precio_antes' => 8.00, 'etiqueta' => '2x1', 'icono' => 'bi-basket2', 'clase' => 'img-snack'],
        ];

        $categorias = [
            ['nombre' => 'Desayunos', 'icono' => 'bi-cup-hot', 'clase' => 'img-desayuno', 'cantidad' => 4],
            ['nombre' => 'Almuerzos', 'icono' => 'bi-egg-fried', 'clase' => 'img-almuerzo', 'cantidad' => 4],
            ['nombre' => 'Bebidas', 'icono' => 'bi-cup-straw', 'clase' => 'img-bebida', 'cantidad' => 4],
            ['nombre' => 'Snacks', 'icono' => 'bi-basket2', 'clase' => 'img-snack', 'cantidad' => 4],
        ];

        return view('inicio', compact('pasos', 'ofertas', 'categorias'));
    }
}