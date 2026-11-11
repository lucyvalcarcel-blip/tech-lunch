@extends('layouts.admin')
@section('titulo', 'Productos')
@section('subtitulo', 'Gestiona los productos, precios y stock del menú.')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <small class="text-gris">{{ $productos->count() }} productos ({{ $activos }} activos)</small>
    <a href="{{ route('admin.productos.create') }}" class="btn btn-tl-amarillo">
        <i class="bi bi-plus-circle me-1"></i> Nuevo producto
    </a>
</div>

<div class="tarjeta tabla-caja">
    <div class="table-responsive">
        <table class="table tabla-tl mb-0">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th class="text-end">Precio</th>
                    <th class="text-center">Stock</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                <tr class="{{ $producto->estado ? '' : 'text-muted' }}">
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if ($producto->imagen)
                                <img src="{{ asset('img/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" style="width: 44px; height: 44px; object-fit: cover; border-radius: 12px">
                            @else
                                <span class="icono-circulo satin-azul" style="width: 44px; height: 44px; font-size: 1.2rem; border-radius: 12px">
                                    <i class="bi {{ $producto->categoria->icono ?? 'bi-tag' }}"></i>
                                </span>
                            @endif
                            <div>
                                <strong class="d-block">
                                    {{ $producto->nombre }}
                                    @if ($producto->destacado)
                                        <i class="bi bi-star-fill text-warning" title="Destacado"></i>
                                    @endif
                                </strong>
                                <small class="text-gris">{{ $producto->descripcion }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $producto->categoria->nombre }}</td>
                    <td class="text-end text-nowrap">S/ {{ number_format($producto->precio, 2) }}</td>
                    <td class="text-center">
                        @if ($producto->stock == 0)
                            <span class="insignia insignia-agotado">Agotado</span>
                        @elseif ($producto->stock <= 5)
                            <span class="insignia insignia-poco">{{ $producto->stock }}</span>
                        @else
                            <span class="insignia insignia-stock">{{ $producto->stock }}</span>
                        @endif
                    </td>
                    <td>
                        @if ($producto->estado)
                            <span class="insignia insignia-stock">Activo</span>
                        @else
                            <span class="insignia insignia-agotado">Inactivo</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.productos.edit', $producto) }}" class="btn btn-warning btn-icono" aria-label="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gris py-4">Todavía no hay productos.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection