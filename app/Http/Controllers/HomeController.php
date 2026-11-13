<?php

namespace App\Http\Controllers;
use App\Models\Categoria;
use App\Models\Producto;
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

                // Productos destacados y activos, con su categoría
        $destacados = Producto::with('categoria')
            ->activos()
            ->destacados()
            ->orderBy('nombre')
            ->get();

        // Categorías activas, con la cantidad de productos activos
        $categorias = Categoria::activas()
            ->withCount(['productos' => fn ($consulta) => $consulta->activos()])
            ->orderBy('nombre')
            ->get();

        return view('inicio', compact('pasos', 'destacados', 'categorias'));

    }
}