<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class InformacionController extends Controller
{
    public function acercaDe(): View
    {
        $valores = [
            ['icono' => 'bi-lightning-charge', 'titulo' => 'Rapidez', 'texto' => 'Pides desde tu celular y recoges sin hacer cola.'],
            ['icono' => 'bi-phone', 'titulo' => 'Pago fácil', 'texto' => 'Pagas con Yape o Plin y el cafetín valida tu pago.'],
            ['icono' => 'bi-geo-alt', 'titulo' => 'Llega a tu aula', 'texto' => 'Recibe tu pedido en el punto de entrega que elijas.'],
        ];

        $equipo = [
            'Morales Lecca, Fabrizio',
            'Silva Silva, Ingrid',
            'Valcarcel Cabia, Lucy',
            'Zumaran Palomino, Gabriel',
        ];

        return view('acerca-de', compact('valores', 'equipo'));
    }
}