{{-- ============================================================
     PEDIDO REGISTRADO (pedidos/show)
     Se muestra al confirmar un pedido y desde "Mis pedidos" (Ver).
     Dato que llega del controlador (PedidoController@show):
       $pedido, con sus detalles, productos y zona cargados
     ============================================================ --}}
<x-layout>
    <x-slot:titulo>Pedido {{ $pedido->codigo }}</x-slot>

    <div class="container py-5" style="max-width: 640px">
        <div class="tarjeta p-4 p-md-5 text-center">

            {{-- Encabezado --}}
            <div class="icono-circulo satin-azul mx-auto mb-3"><i class="bi bi-check2-circle"></i></div>
            <h1 class="h3 mb-1">¡Pedido registrado!</h1>

            {{-- El mensaje cambia según el tipo de entrega --}}
            <p class="text-gris mb-4">
                @if ($pedido->tipo_entrega === 'delivery')
                    Te llevaremos tu pedido a tu aula. Ten a la mano este código.
                @else
                    Presenta este código en el cafetín para recoger tu pedido.
                @endif
            </p>

            {{-- Código del pedido (TL-0001) --}}
            <div class="display-6 fw-bold mb-4">{{ $pedido->codigo }}</div>

            {{-- ---------- DATOS DE LA ENTREGA ---------- --}}
            <div class="text-start rounded-4 p-3 mb-4 small" style="background:var(--tl-fondo)">
                <div class="row g-2">
                    <div class="col-6">
                        <span class="text-gris d-block">Entrega</span>
                        <strong>{{ $pedido->tipo_entrega === 'delivery' ? 'Delivery en el campus' : 'Recojo en el cafetín' }}</strong>
                    </div>

                    {{-- Con recojo no hay zona (es null): por eso la condición --}}
                    <div class="col-6">
                        <span class="text-gris d-block">Lugar</span>
                        <strong>{{ $pedido->zona ? $pedido->zona->nombre . ' · ' . $pedido->aula : 'Cafetín de Tecsup' }}</strong>
                    </div>

                    {{-- La hora elegida solo existe con delivery --}}
                    @if ($pedido->hora_entrega)
                        <div class="col-6">
                            <span class="text-gris d-block">Hora</span>
                            <strong>{{ $pedido->hora_entrega->format('g:i') }} p. m.</strong>
                        </div>
                    @endif

                    {{-- Tiempo límite: hora + 10 min (delivery) u hora de cierre (recojo) --}}
                    <div class="col-6">
                        <span class="text-gris d-block">Te esperamos hasta</span>
                        <strong>{{ $pedido->limite_entrega->format('g:i') }} p. m.</strong>
                    </div>
                </div>
            </div>

            {{-- ---------- PRODUCTOS Y TOTAL ---------- --}}
            <div class="text-start">

                {{-- Cada línea del pedido (detalle_pedidos) con su subtotal guardado --}}
                @foreach ($pedido->detalles as $detalle)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $detalle->cantidad }} × {{ $detalle->producto->nombre }}</span>
                        <span>S/ {{ number_format($detalle->subtotal, 2) }}</span>
                    </div>
                @endforeach

            {{-- Línea de la entrega: delivery con su costo, o recojo gratis --}}
                <div class="d-flex justify-content-between mb-2">
                    @if ($pedido->tipo_entrega === 'delivery')
                        <span class="text-gris">Delivery en el campus</span>
                        <span>S/ {{ number_format($pedido->costo_delivery, 2) }}</span>
                    @else
                        <span class="text-gris">Recojo en el cafetín</span>
                        <span>Gratis</span>
                    @endif
                </div>

                <hr>

                {{-- Total guardado en la base (calculado por Laravel, no por el navegador) --}}
                <div class="d-flex justify-content-between mb-2">
                    <strong>Total</strong>
                    <span class="precio fs-5">S/ {{ number_format($pedido->total, 2) }}</span>
                </div>

                {{-- ---------- PAGO ---------- --}}
                <div class="d-flex justify-content-between text-gris small">
                    @if (in_array($pedido->metodo_pago, ['debito', 'credito']))
                        {{-- Tarjeta: solo la marca y los últimos 4 dígitos (lo único que se guarda) --}}
                        <span>Pago con tarjeta de {{ $pedido->metodo_pago === 'credito' ? 'crédito' : 'débito' }}</span>
                        <span>
                            {{ $pedido->tarjeta_marca }} •••• {{ $pedido->tarjeta_ultimos4 }}
                            @if ($pedido->cuotas > 1) · {{ $pedido->cuotas }} cuotas @endif
                        </span>
                    @else
                        {{-- Yape o Plin: el número de operación --}}
                        <span>Pago con {{ ucfirst($pedido->metodo_pago) }}</span>
                        <span>Operación N.º {{ $pedido->numero_operacion }}</span>
                    @endif
                </div>
            </div>

            {{-- ---------- BOTONES ---------- --}}
            <div class="d-flex gap-2 justify-content-center mt-4">
                <a href="{{ route('pedidos.index') }}" class="btn btn-tl-borde">Mis pedidos</a>
                <a href="{{ route('menu') }}" class="btn btn-tl-amarillo">Volver al menú</a>
            </div>
        </div>
    </div>
</x-layout>