@extends('layouts.admin')

@section('titulo', 'Pedidos')
@section('subtitulo', 'Valida pagos y marca las entregas.')

@section('contenido')
    {{-- Filtros (GET: quedan en la URL) --}}
    <form method="GET" class="tarjeta p-3 mb-3 row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label small mb-1">Estado</label>
            <select name="estado" class="form-select">
                <option value="">Todos</option>
                @foreach (\App\Models\Pedido::ESTADOS as $estado)
                    <option value="{{ $estado }}" @selected(request('estado') === $estado)>{{ $estado }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small mb-1">Entrega</label>
            <select name="tipo_entrega" class="form-select">
                <option value="">Todas</option>
                <option value="recojo" @selected(request('tipo_entrega') === 'recojo')>Recojo</option>
                <option value="delivery" @selected(request('tipo_entrega') === 'delivery')>Delivery</option>
            </select>
        </div>
        <div class="col-md-2">
            <div class="form-check">
                <input type="checkbox" id="hoy" name="hoy" value="1" class="form-check-input" @checked(request('hoy'))>
                <label for="hoy" class="form-check-label">Solo hoy</label>
            </div>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-tl-amarillo flex-grow-1"><i class="bi bi-funnel me-1"></i> Filtrar</button>
            <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>

    <div class="tarjeta tabla-caja">
        <div class="table-responsive">
            <table class="table tabla-tl mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Pedido</th>
                        <th>Entrega</th>
                        <th class="text-end">Total</th>
                        <th>Estado</th>
                        <th class="text-center">Ver</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pedidos as $pedido)
                        <tr>
                            <td><strong>{{ $pedido->codigo }}</strong></td>
                            <td>{{ $pedido->usuario?->name }}<br><small class="text-muted">{{ $pedido->celular }}</small></td>
                            <td>{{ $pedido->created_at->format('d/m H:i') }}</td>
                            <td>
                                @if ($pedido->tipo_entrega === 'delivery')
                                    Delivery · {{ $pedido->zona?->nombre }} {{ $pedido->aula }}
                                @else
                                    Recojo
                                @endif
                                <br><small class="text-muted">Hasta {{ $pedido->limite_entrega->format('g:i a') }}</small>
                            </td>
                            <td class="text-end">S/ {{ number_format($pedido->total, 2) }}</td>
                            <td>
                                <span class="badge text-bg-{{ \App\Models\Pedido::COLORES[$pedido->estado] }}">{{ $pedido->estado }}</span>
                                @if ($pedido->puedeMarcarNoLlego())
                                    <br><small class="text-danger"><i class="bi bi-alarm"></i> Pasó el límite</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.pedidos.show', $pedido) }}" class="btn btn-sm btn-outline-primary btn-icono"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No hay pedidos con esos filtros.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection