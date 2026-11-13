<?php

namespace App\Http\Controllers;
use App\Models\Producto;

use Illuminate\Http\Request;

class CarritoController extends Controller
{
public function store(Producto $producto)
{
    $carrito = session('carrito', []);
    $cantidadActual = $carrito[$producto->id] ?? 0;

    if (! $producto->estado || $cantidadActual >= $producto->stock) {
        return back()->with('error', 'No hay stock suficiente de ' . $producto->nombre . '.');
    }

    $carrito[$producto->id] = $cantidadActual + 1;
    session(['carrito' => $carrito]);

    return back()->with('exito', $producto->nombre . ' agregado al carrito.');
}
public function index()
{
    $carrito = session('carrito', []);
    $productos = Producto::with('categoria')->whereIn('id', array_keys($carrito))->get();

    $items = $productos->map(fn ($producto) => [
        'producto' => $producto,
        'cantidad' => $carrito[$producto->id],
        'subtotal' => $producto->precio * $carrito[$producto->id],
    ]);

    $total = $items->sum('subtotal');

    return view('carrito.index', compact('items', 'total'));
}

public function update(Request $request, Producto $producto)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1|max:' . $producto->stock,
    ]);

    $carrito = session('carrito', []);
    $carrito[$producto->id] = (int) $request->cantidad;
    session(['carrito' => $carrito]);

    return back();
}

public function destroy(Producto $producto)
{
    $carrito = session('carrito', []);
    unset($carrito[$producto->id]);
    session(['carrito' => $carrito]);

    return back()->with('exito', $producto->nombre . ' quitado del carrito.');
}
}
