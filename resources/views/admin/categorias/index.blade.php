@extends('layouts.admin')

@section('titulo', 'Categorías')
@section('subtitulo', 'Organiza los productos del menú por categorías.')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <small class="text-gris">{{ $categorias->count() }} categorías</small>
        <a href="{{ route('admin.categorias.create') }}" class="btn btn-tl-amarillo">
            <i class="bi bi-plus-circle me-1"></i> Nueva categoría
        </a>
    </div>

    <div class="tarjeta tabla-caja">
        <div class="table-responsive">
            <table class="table tabla-tl mb-0">
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th class="text-center">Productos</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="icono-circulo satin-azul" style="width:40px;height:40px;font-size:1.1rem;border-radius:12px">
                                        <i class="bi {{ $categoria->icono ?? 'bi-tag' }}"></i>
                                    </span>
                                    <strong>{{ $categoria->nombre }}</strong>
                                </div>
                            </td>
                            <td>{{ $categoria->descripcion ?? '—' }}</td>
                            <td class="text-center">{{ $categoria->productos_count }}</td>
                            <td>
                                @if ($categoria->estado)
                                    <span class="insignia insignia-stock">Activa</span>
                                @else
                                    <span class="insignia insignia-agotado">Inactiva</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.categorias.edit', $categoria) }}"
                                   class="btn btn-warning btn-icono" aria-label="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gris py-4">Todavía no hay categorías.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection