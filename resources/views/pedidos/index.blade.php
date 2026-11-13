<x-layout>
    <x-slot:titulo>Mis pedidos</x-slot>

    <div class="container py-5">
        <h1 class="seccion-titulo h2 mb-4">Mis pedidos</h1>

        @if ($pedidos->isEmpty())
            <div class="tarjeta p-5 text-center">
                <i class="bi bi-bag fs-1 text-gris"></i>
                <p class="mt-3 mb-4">Todavía no has hecho pedidos.</p>
                <a href="{{ route('menu') }}" class="btn btn-tl-amarillo">Ver el menú</a>
            </div>
        @else
            <div class="tarjeta tabla-caja">
                <div class="table-responsive">
                    <table class="table tabla-tl mb-0">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Fecha</th>
                                <th class="text-center">Productos</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                                <tr>
                                    <td><strong>{{ $pedido->codigo }}</strong></td>
                                    <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">{{ $pedido->detalles_count }}</td>
                                    <td class="text-end">S/ {{ number_format($pedido->total, 2) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-tl-borde btn-sm">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-layout>