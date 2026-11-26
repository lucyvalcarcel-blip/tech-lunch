@extends('layouts.admin')

@section('titulo', 'Pedido ' . $pedido->codigo)
@section('subtitulo', 'Registrado el ' . $pedido->created_at->format('d/m/Y \a \l\a\s H:i'))

@section('contenido')
    <div class="row g-4">
        {{-- ===== IZQUIERDA: datos del pedido ===== --}}
        <div class="col-lg-8">
            <div class="tarjeta p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 mb-0">Cliente y entrega</h2>
                    <span class="badge fs-6 text-bg-{{ \App\Models\Pedido::COLORES[$pedido->estado] }}">{{ $pedido->estado }}</span>
                </div>
                <div class="row g-3 small">
                    <div class="col-6">
                        <span class="text-muted d-block">Cliente</span>
                        <strong>{{ $pedido->usuario?->name }}</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-muted d-block">Celular</span>
                        <a href="https://wa.me/51{{ $pedido->celular }}" target="_blank"><i class="bi bi-whatsapp"></i> {{ $pedido->celular }}</a>
                    </div>
                    <div class="col-6">
                        <span class="text-muted d-block">Entrega</span>
                        @if ($pedido->tipo_entrega === 'delivery')
                            <strong>Delivery · {{ $pedido->zona?->nombre }} · {{ $pedido->aula }}</strong>
                            @if ($pedido->referencia)<br><small>{{ $pedido->referencia }}</small>@endif
                        @else
                            <strong>Recojo en el cafetín</strong>
                        @endif
                    </div>
                    <div class="col-6">
                        <span class="text-muted d-block">Tiempo límite</span>
                        <strong>{{ $pedido->limite_entrega->format('g:i a') }}</strong>
                        @if ($pedido->hora_entrega) <small class="text-muted">(hora {{ $pedido->hora_entrega->format('g:i a') }})</small> @endif
                    </div>
                </div>
            </div>

            <div class="tarjeta p-4">
                <h2 class="h5 mb-3">Productos y pago</h2>
                @foreach ($pedido->detalles as $detalle)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $detalle->cantidad }} × {{ $detalle->producto->nombre }}</span>
                        <span>S/ {{ number_format($detalle->subtotal, 2) }}</span>
                    </div>
                @endforeach
                @if ($pedido->costo_delivery > 0)
                    <div class="d-flex justify-content-between mb-2 text-muted"><span>Delivery</span><span>S/ {{ number_format($pedido->costo_delivery, 2) }}</span></div>
                @endif
                @if ($pedido->cupon)
                    <div class="d-flex justify-content-between mb-2 text-success"><span>Cupón {{ $pedido->cupon->codigo }}</span><span>− S/ {{ number_format($pedido->descuento, 2) }}</span></div>
                @endif
                <hr>
                <div class="d-flex justify-content-between mb-3"><strong>Total</strong><strong>S/ {{ number_format($pedido->total, 2) }}</strong></div>

                {{-- Lo que el encargado revisa para validar el pago --}}
                <div class="alert alert-light border mb-0 small">
                    @if (in_array($pedido->metodo_pago, ['debito', 'credito']))
                        Tarjeta de {{ $pedido->metodo_pago === 'credito' ? 'crédito' : 'débito' }}:
                        <strong>{{ $pedido->tarjeta_marca }} •••• {{ $pedido->tarjeta_ultimos4 }}</strong>
                        @if ($pedido->cuotas > 1) · {{ $pedido->cuotas }} cuotas @endif
                    @else
                        {{ ucfirst($pedido->metodo_pago) }} · N.º de operación: <strong>{{ $pedido->numero_operacion }}</strong>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== DERECHA: acciones del encargado ===== --}}
        <div class="col-lg-4">
            <div class="tarjeta p-4">
                <h2 class="h5 mb-3">Acciones</h2>

                @php
                    // acción => [texto, color, ícono, ¿se puede?]
                    $acciones = [
                        'validar' => ['Validar pago', 'success', 'bi-check-circle', $pedido->puedeValidar()],
                        'rechazar' => ['Rechazar pago', 'danger', 'bi-x-circle', $pedido->puedeRechazar()],
                        'entregar' => ['Marcar entregado', 'primary', 'bi-bag-check', $pedido->puedeEntregar()],
                        'no_llego' => ['No llegó', 'secondary', 'bi-alarm', $pedido->puedeMarcarNoLlego()],
                    ];
                @endphp

                @foreach ($acciones as $accion => [$texto, $color, $icono, $sePuede])
                    @if ($sePuede)
                        <form method="POST" action="{{ route('admin.pedidos.estado', $pedido) }}" class="mb-2"
                              onsubmit="return confirm('¿{{ $texto }} del pedido {{ $pedido->codigo }}?')">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="accion" value="{{ $accion }}">
                            <button class="btn btn-{{ $color }} w-100"><i class="bi {{ $icono }} me-1"></i> {{ $texto }}</button>
                        </form>
                    @endif
                @endforeach

                {{-- Confirmado pero aún no pasa el límite: "No llegó" todavía no se puede --}}
                @if ($pedido->puedeEntregar() && ! $pedido->puedeMarcarNoLlego())
                    <p class="small text-muted mb-0">"No llegó" se habilita después de las {{ $pedido->limite_entrega->format('g:i a') }}.</p>
                @endif

                @if (in_array($pedido->estado, [\App\Models\Pedido::ENTREGADO, \App\Models\Pedido::RECHAZADO, \App\Models\Pedido::NO_LLEGO]))
                    <p class="text-muted mb-0">Pedido cerrado: no hay acciones pendientes.</p>
                @endif

                <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary w-100 mt-3">Volver a pedidos</a>
            </div>
        </div>
    </div>
@endsection