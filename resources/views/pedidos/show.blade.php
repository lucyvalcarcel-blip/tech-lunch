<x-layout>
    <x-slot:titulo>Pedido {{ $pedido->codigo }}</x-slot>
    <div class="container py-5" style="max-width: 640px">
        <div class="tarjeta p-4 p-md-5 text-center">
            <div class="icono-circulo satin-azul mx-auto mb-3"><i class="bi bi-check2-circle"></i></div>
            <h1 class="h3 mb-1">¡Pedido registrado!</h1>

            <p class="text-gris mb-4">
                  @if ($pedido->tipo_entrega === 'delivery')
                      Te llevaremos tu pedido a tu aula. Ten a la mano este código.
                  @else
                       Presenta este código en el cafetín para recoger tu pedido.
                  @endif
            </p>

            <div class="display-6 fw-bold mb-4">{{ $pedido->codigo }}</div>
                <div class="text-start rounded-4 p-3 mb-4 small" style="background:var(--tl-fondo)">
                    <div class="row g-2">
                        <div class="col-6">
                            <span class="text-gris d-block">Entrega</span>
                            <strong>{{ $pedido->tipo_entrega === 'delivery' ? 'Delivery en el campus' : 'Recojo en el cafetín' }}</strong>
                        </div>
                        <div class="col-6">
                             <span class="text-gris d-block">Lugar</span>
                             <strong>{{ $pedido->zona ? $pedido->zona->nombre . ' · ' . $pedido->aula : 'Cafetín de Tecsup' }}</strong>
                        </div>
                        @if ($pedido->hora_entrega)
                            <div class="col-6">
                                  <span class="text-gris d-block">Hora</span>
                                    <strong>{{ $pedido->hora_entrega->format('g:i') }} p. m.</strong>
                             </div>
                         @endif
                       <div class="col-6">
                            <span class="text-gris d-block">Te esperamos hasta</span>
                            <strong>{{ $pedido->limite_entrega->format('g:i') }} p. m.</strong>
                        </div>
                  </div>
            </div>

            <div class="text-start">
                @foreach ($pedido->detalles as $detalle)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $detalle->cantidad }} × {{ $detalle->producto->nombre }}</span>
                        <span>S/ {{ number_format($detalle->subtotal, 2) }}</span>
                    </div>
                @endforeach

                @if ($pedido->costo_delivery > 0)
                   <div class="d-flex justify-content-between mb-2">
                        <span class="text-gris">Delivery</span>
                        <span>S/ {{ number_format($pedido->costo_delivery, 2) }}</span>
                   </div>
                @endif

                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <strong>Total</strong>
                    <span class="precio fs-5">S/ {{ number_format($pedido->total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between text-gris small">
                    <span>Pago con {{ ucfirst($pedido->metodo_pago) }}</span>
                    <span>Operación N.º {{ $pedido->numero_operacion }}</span>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-center mt-4">
                <a href="{{ route('pedidos.index') }}" class="btn btn-tl-borde">Mis pedidos</a>
                <a href="{{ route('menu') }}" class="btn btn-tl-amarillo">Volver al menú</a>
            </div>
        </div>
    </div>
</x-layout>