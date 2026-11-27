<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;   // (Fabrizio) para borrar imágenes


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
            'imagen'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],   // (Fabrizio)
        ], [], [
            'categoria_id' => 'categoría',
        ]);

        // (Fabrizio) Guarda el archivo en storage/app/public/productos y deja su ruta en la base
        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

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
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $datos = $request->validate([
            'nombre'       => ['required', 'string', 'max:150',
                            Rule::unique('productos', 'nombre')->ignore($producto->id)],
            'descripcion'  => ['nullable', 'string', 'max:500'],
            'precio'       => ['required', 'numeric', 'min:0.10', 'max:9999.99'],
            'stock'        => ['required', 'integer', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'destacado'    => ['required', 'boolean'],
            'estado'       => ['required', 'boolean'],
            'imagen'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],   // (Fabrizio)
        ], [], [
            'categoria_id' => 'categoría',
        ]);

        // (Fabrizio) Si sube una foto nueva: borra la anterior y guarda la nueva
        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($datos);

        return redirect()->route('admin.productos.index')
            ->with('exito', 'Producto actualizado correctamente.');
    }

    // (Fabrizio) Eliminación LÓGICA: no se borra, solo se desactiva (deja de verse en el menú)
    public function destroy(Producto $producto)
    {
        $producto->update(['estado' => false]);

        return redirect()->route('admin.productos.index')
            ->with('exito', 'Producto desactivado correctamente.');
    }
}