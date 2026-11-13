<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $pedidos = Pedido::where('user_id', auth()->id())
        ->withCount('detalles')
        ->latest()
        ->get();

    return view('pedidos.index', compact('pedidos'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $carrito = session('carrito', []);

    if (empty($carrito)) {
        return redirect()->route('menu')->with('error', 'Tu carrito está vacío.');
    }

    $productos = Producto::whereIn('id', array_keys($carrito))->get();
    $total = $productos->sum(fn ($producto) => $producto->precio * $carrito[$producto->id]);

    return view('pedidos.create', compact('productos', 'carrito', 'total'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $datos = $request->validate([
        'celular'          => 'required|digits:9',
        'metodo_pago'      => 'required|in:yape,plin',
        'numero_operacion' => 'required|string|max:20',
    ]);

    $carrito = session('carrito', []);
    if (empty($carrito)) {
        return redirect()->route('menu');
    }

    $productos = Producto::whereIn('id', array_keys($carrito))->get();

    foreach ($productos as $producto) {
        if ($carrito[$producto->id] > $producto->stock) {
            return back()->withInput()->with('error', 'Ya no hay stock suficiente de ' . $producto->nombre . '.');
        }
    }

    $total = $productos->sum(fn ($p) => $p->precio * $carrito[$p->id]);

    $pedido = DB::transaction(function () use ($datos, $productos, $carrito, $total) {
        $pedido = Pedido::create($datos + [
            'user_id' => auth()->id(),
            'total'   => $total,
        ]);

        $pedido->update(['codigo' => 'TL-' . str_pad($pedido->id, 4, '0', STR_PAD_LEFT)]);

        foreach ($productos as $producto) {
            $cantidad = $carrito[$producto->id];
            $pedido->detalles()->create([
                'producto_id'     => $producto->id,
                'cantidad'        => $cantidad,
                'precio_unitario' => $producto->precio,
                'subtotal'        => $producto->precio * $cantidad,
            ]);
            $producto->decrement('stock', $cantidad);
        }

        return $pedido;
    });

    session()->forget('carrito');

    return redirect()->route('pedidos.show', $pedido)
        ->with('exito', 'Pedido ' . $pedido->codigo . ' registrado.');
}

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
{
    abort_if($pedido->user_id !== auth()->id(), 403);

    $pedido->load('detalles.producto');

    return view('pedidos.show', compact('pedido'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
