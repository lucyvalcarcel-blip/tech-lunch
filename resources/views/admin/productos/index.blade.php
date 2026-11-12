@extends('layouts.admin')

@section('titulo', 'Productos')
@section('subtitulo', 'Administra los platos y bebidas del cafetín.')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <small class="text-gris">{{ $productos->count() }} productos</small>
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
                        <tr>
                            <td>
                                <strong>{{ $producto->nombre }}</strong>
                                @if ($producto->destacado)
                                    <i class="bi bi-star-fill text-warning ms-1" title="Destacado"></i>
                                @endif
                            </td>
                            <td>{{ $producto->categoria->nombre }}</td>
                            <td class="text-end text-nowrap">S/ {{ $producto->precio }}</td>
                            <td class="text-center">{{ $producto->stock }}</td>
                            <td>
                                @if ($producto->estado)
                                    <span class="insignia insignia-stock">Activo</span>
                                @else
                                    <span class="insignia insignia-agotado">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.productos.edit', $producto) }}"
                                   class="btn btn-warning btn-icono" aria-label="Editar">
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