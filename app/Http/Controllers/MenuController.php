<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
class MenuController extends Controller
{
    public function index()
{
    $categorias = Categoria::activas()
        ->with(['productos' => fn ($consulta) => $consulta->activos()->orderBy('nombre')])
        ->orderBy('nombre')
        ->get();

    return view('menu.index', compact('categorias'));
}
}
