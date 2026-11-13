<x-layout>
    <x-slot:titulo>Mi carrito</x-slot>

    <div class="container py-5">
        <h1 class="seccion-titulo h2 mb-4">Mi carrito</h1>

        @if (session('exito'))
            <div class="alert alert-success">{{ session('exito') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        @if ($items->isEmpty())
            <div class="tarjeta p-5 text-center">
                <i class="bi bi-cart3 fs-1 text-gris"></i>
                <p class="mt-3 mb-4">Tu carrito está vacío.</p>
                <a href="{{ route('menu') }}" class="btn btn-tl-amarillo">Ver el menú</a>
            </div>
        @else
            <div class="row g-4">
                {{-- Productos --}}
                <div class="col-lg-8">
                    <div class="tarjeta p-2 p-md-3">
                        @foreach ($items as $item)
                            <div class="d-flex align-items-center gap-3 p-3 {{ $loop->last ? '' : 'border-bottom' }} flex-wrap">
                                <div class="producto-img producto-mini {{ $item['producto']->categoria->clase_imagen }}">
                                    <i class="bi {{ $item['producto']->categoria->icono }}"></i>
                                </div>

                                <div class="flex-grow-1">
                                    <strong class="d-block">{{ $item['producto']->nombre }}</strong>
                                    <small class="text-gris">S/ {{ $item['producto']->precio }} c/u</small>
                                </div>

                                {{-- Botones − y + --}}
                                <div class="cantidad">
                                    <form method="POST" action="{{ route('carrito.update', $item['producto']) }}" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="cantidad" value="{{ $item['cantidad'] - 1 }}">
                                        <button type="submit" aria-label="Quitar uno" @disabled($item['cantidad'] <= 1)>−</button>
                                    </form>
                                    <span>{{ $item['cantidad'] }}</span>
                                    <form method="POST" action="{{ route('carrito.update', $item['producto']) }}" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="cantidad" value="{{ $item['cantidad'] + 1 }}">
                                        <button type="submit" aria-label="Agregar uno">+</button>
                                    </form>
                                </div>

                                <strong class="precio fs-6" style="min-width:80px;text-align:right">
                                    S/ {{ number_format($item['subtotal'], 2) }}
                                </strong>

                                {{-- Quitar --}}
                                <form method="POST" action="{{ route('carrito.destroy', $item['producto']) }}" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-icono text-danger" aria-label="Quitar producto">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('menu') }}" class="btn btn-tl-borde mt-3">
                        <i class="bi bi-arrow-left me-1"></i> Seguir comprando
                    </a>
                </div>

                {{-- Resumen --}}
                <div class="col-lg-4">
                    <div class="tarjeta p-4">
                        <h2 class="h5 mb-3">Resumen</h2>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-gris">Productos ({{ $items->sum('cantidad') }})</span>
                            <span>S/ {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-gris">Recojo en el cafetín</span>
                            <span class="text-gris">Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <strong>Total</strong>
                            <span class="precio fs-4">S/ {{ number_format($total, 2) }}</span>
                        </div>
                        <a href="{{ Route::has('pedidos.create') ? route('pedidos.create') : '#' }}" class="btn btn-tl btn-lg w-100">
                            Continuar <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layout>