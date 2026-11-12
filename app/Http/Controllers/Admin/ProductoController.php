<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Categoria;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with('categoria')
            ->orderBy('nombre')
            ->get();

        return view('admin.productos.index', compact('productos'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $producto = new Producto(['estado' => true, 'destacado' => false, 'stock' => 0]);
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.productos.create', compact('producto', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'       => ['required', 'string', 'max:150', 'unique:productos,nombre'],
            'descripcion'  => ['nullable', 'string', 'max:500'],
            'precio'       => ['required', 'numeric', 'min:0.10', 'max:9999.99'],
            'stock'        => ['required', 'integer', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'destacado'    => ['required', 'boolean'],
            'estado'       => ['required', 'boolean'],
        ], [], [
            'categoria_id' => 'categoría',
        ]);

        Producto::create($datos);

        return redirect()->route('admin.productos.index')
            ->with('exito', 'Producto registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
