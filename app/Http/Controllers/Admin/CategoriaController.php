<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
     $categorias = Categoria::withCount('productos')
        ->orderBy('nombre')
        ->get();

    return view('admin.categorias.index', compact('categorias'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoria = new Categoria(['estado' => true]);

    return view('admin.categorias.create', compact('categoria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
        'nombre' => ['required', 'string', 'max:50', 'unique:categorias,nombre'],
        'descripcion' => ['nullable', 'string', 'max:255'],
        'icono' => ['nullable', 'string', 'max:50'],
        'estado' => ['required', 'boolean'],
    ]);

    Categoria::create($datos);

    return redirect()->route('admin.categorias.index')
        ->with('exito', 'Categoría registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
          return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $datos = $request->validate([
        'nombre' => ['required', 'string', 'max:50', Rule::unique('categorias', 'nombre')->ignore($categoria->id)],
        'descripcion' => ['nullable', 'string', 'max:255'],
        'icono' => ['nullable', 'string', 'max:50'],
        'estado' => ['required', 'boolean'],
    ]);

    $categoria->update($datos);

    return redirect()->route('admin.categorias.index')
        ->with('exito', 'Categoría actualizada correctamente.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //
    }
}
