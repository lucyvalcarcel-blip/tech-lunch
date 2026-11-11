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

    public function create()
    {
        $categorias = \App\Models\Categoria::orderBy('nombre')->get();
        return view('admin.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'estado' => 'sometimes|boolean',
            'destacado' => 'sometimes|boolean',
            'imagen' => 'nullable|string|max:255',
        ]);

        $validated['estado'] = $request->has('estado');
        $validated['destacado'] = $request->has('destacado');

        \App\Models\Producto::create($validated);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit(\App\Models\Producto $producto)
    {
        $categorias = \App\Models\Categoria::orderBy('nombre')->get();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, \App\Models\Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'estado' => 'sometimes|boolean',
            'destacado' => 'sometimes|boolean',
            'imagen' => 'nullable|string|max:255',
        ]);

        $validated['estado'] = $request->has('estado');
        $validated['destacado'] = $request->has('destacado');

        $producto->update($validated);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado exitosamente.');
    }
}

