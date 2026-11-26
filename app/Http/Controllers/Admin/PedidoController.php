<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    // Listado del encargado, con filtros opcionales
    public function index(Request $request)
    {
        $pedidos = Pedido::with(['usuario', 'zona'])
            ->when($request->estado, fn ($consulta, $estado) => $consulta->where('estado', $estado))
            ->when($request->tipo_entrega, fn ($consulta, $tipo) => $consulta->where('tipo_entrega', $tipo))
            ->when($request->boolean('hoy'), fn ($consulta) => $consulta->whereDate('created_at', today()))
            ->latest()
            ->get();

        return view('admin.pedidos.index', compact('pedidos'));
    }
}