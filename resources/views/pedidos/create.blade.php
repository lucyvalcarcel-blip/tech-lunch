<x-layout>
    <x-slot:titulo>Confirmar pedido</x-slot>

    <div class="container py-5">
        <h1 class="seccion-titulo h2 mb-4">Confirmar pedido</h1>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row g-4">
            {{-- Formulario --}}
            <div class="col-lg-7">
                <div class="tarjeta p-4">
                    <h2 class="h5 mb-3"><i class="bi bi-shop me-2"></i>Recojo en el cafetín</h2>
                    <p class="text-gris mb-4">Recoge tu pedido en el cafetín de Tecsup, presentando tu código.</p>

                    <form method="POST" action="{{ route('pedidos.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="text" id="celular" name="celular" maxlength="9"
                                   value="{{ old('celular') }}" placeholder="987654321"
                                   class="form-control @error('celular') is-invalid @enderror">
                            @error('celular')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Método de pago</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="yape" value="yape"
                                       @checked(old('metodo_pago', 'yape') === 'yape')>
                                <label class="form-check-label" for="yape">Yape</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="plin" value="plin"
                                       @checked(old('metodo_pago') === 'plin')>
                                <label class="form-check-label" for="plin">Plin</label>
                            </div>
                            @error('metodo_pago')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="numero_operacion" class="form-label">Número de operación</label>
                            <input type="text" id="numero_operacion" name="numero_operacion" maxlength="20"
                                   value="{{ old('numero_operacion') }}" placeholder="Lo encuentras en tu app de Yape o Plin"
                                   class="form-control @error('numero_operacion') is-invalid @enderror">
                            @error('numero_operacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-tl btn-lg w-100">
                            <i class="bi bi-check2-circle me-1"></i> Confirmar pedido
                        </button>
                    </form>
                </div>
            </div>

            {{-- Resumen --}}
            <div class="col-lg-5">
                <div class="tarjeta p-4">
                    <h2 class="h5 mb-3">Tu pedido</h2>
                    @foreach ($productos as $producto)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $carrito[$producto->id] }} × {{ $producto->nombre }}</span>
                            <span>S/ {{ number_format($producto->precio * $carrito[$producto->id], 2) }}</span>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Total</strong>
                        <span class="precio fs-4">S/ {{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>