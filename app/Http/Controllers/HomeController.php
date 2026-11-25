<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Oferta;      // (Ingrid)
use App\Models\Producto;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $pasos = [
            ['icono' => 'bi-hand-index-thumb', 'color' => 'satin-azul', 'titulo' => '1. Elige', 'texto' => 'Revisa el menú del día, las bebidas y los snacks, y agrégalos a tu carrito.'],
            ['icono' => 'bi-phone', 'color' => 'satin-amarillo', 'titulo' => '2. Paga', 'texto' => 'Paga con Yape o Plin o tarjeta de débito o crédito.'],
            ['icono' => 'bi-bag-check', 'color' => 'satin-azul', 'titulo' => '3. Recibe', 'texto' => 'Recógelo en el cafetín o recibelo en tu aula con tu código de pedido.'],
        ];

        // Ofertas vigentes HOY, de productos activos (Ingrid)
        $ofertas = Oferta::vigentes()
            ->whereHas('producto', fn ($consulta) => $consulta->activos())
            ->with('producto.categoria')       // producto y su categoría, sin N+1
            ->orderBy('fecha_fin')             // las que terminan antes, primero
            ->get();

        // Productos destacados y activos, con su categoría y su oferta de hoy
        $destacados = Producto::with(['categoria', 'ofertaVigente'])   // (Ingrid) + ofertaVigente
            ->activos()
            ->destacados()
            ->orderBy('nombre')
            ->get();

        // Categorías activas, con la cantidad de productos activos
        $categorias = Categoria::activas()
            ->withCount(['productos' => fn ($consulta) => $consulta->activos()])
            ->orderBy('nombre')
            ->get();

        return view('inicio', compact('pasos', 'ofertas', 'destacados', 'categorias'));
    }
}