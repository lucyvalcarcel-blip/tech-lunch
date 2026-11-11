<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->orderBy('nombre')->get();
        $activos = $productos->where('estado', true)->count();
        return view('admin.productos.index', compact('productos', 'activos'));
    }
}
