<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Cupon;
use Illuminate\Support\Facades\DB;
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
    
    // Detalle del pedido para el encargado
    public function show(Pedido $pedido)
    {
        $pedido->load(['detalles.producto', 'usuario', 'zona', 'cupon']);

        return view('admin.pedidos.show', compact('pedido'));
    }

    // Los 4 botones: validar, rechazar, entregar, no_llego
    public function cambiarEstado(Request $request, Pedido $pedido)
    {
        $accion = $request->validate([
            'accion' => 'required|in:validar,rechazar,entregar,no_llego',
        ])['accion'];

        // ¿Se puede hacer esa acción en el estado actual?
        $permitido = match ($accion) {
            'validar' => $pedido->puedeValidar(),
            'rechazar' => $pedido->puedeRechazar(),
            'entregar' => $pedido->puedeEntregar(),
            'no_llego' => $pedido->puedeMarcarNoLlego(),
        };
        abort_unless($permitido, 403, 'Esta acción no está permitida en el estado actual del pedido.');

        $nuevoEstado = match ($accion) {
            'validar' => Pedido::CONFIRMADO,
            'rechazar' => Pedido::RECHAZADO,
            'entregar' => Pedido::ENTREGADO,
            'no_llego' => Pedido::NO_LLEGO,
        };

        DB::transaction(function () use ($pedido, $nuevoEstado) {
            // Pago inválido: se devuelve el stock y el cupón vuelve a estar disponible
            if ($nuevoEstado === Pedido::RECHAZADO) {
                foreach ($pedido->detalles as $detalle) {
                    $detalle->producto->increment('stock', $detalle->cantidad);
                }
                $pedido->cupon?->update(['estado' => Cupon::DISPONIBLE]);
            }

            $pedido->update(['estado' => $nuevoEstado]);
        });

        return redirect()->route('admin.pedidos.show', $pedido)
            ->with('exito', 'Pedido ' . $pedido->codigo . ': ' . $nuevoEstado . '.');
    }
}