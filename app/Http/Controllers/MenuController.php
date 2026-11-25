<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

class MenuController extends Controller
{
    public function index()
    {
        // Categorías activas con sus productos activos.
        // (Ingrid) Cada producto trae su oferta de hoy, para mostrar el precio tachado
        $categorias = Categoria::activas()
            ->with(['productos' => fn ($consulta) => $consulta->activos()
                ->with('ofertaVigente')
                ->orderBy('nombre')])
            ->orderBy('nombre')
            ->get();

        return view('menu.index', compact('categorias'));
    }
}