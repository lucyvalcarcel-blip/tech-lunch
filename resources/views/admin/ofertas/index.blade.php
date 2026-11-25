@extends('layouts.admin')

@section('titulo', 'Ofertas')
@section('subtitulo', 'Administra los descuentos, ofertas del día y combos.')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.ofertas.create') }}" class="btn btn-tl-amarillo">
            <i class="bi bi-plus-circle me-1"></i> Nueva oferta
        </a>
    </div>

    {{-- Color del badge según el estado --}}
    @php
        $colores = [
            'Vigente' => 'success',
            'Programada' => 'info',
            'Vencida' => 'secondary',
            'Inactiva' => 'danger',
        ];
    @endphp

    <div class="tarjeta tabla-caja">
        <div class="table-responsive">
            <table class="table tabla-tl mb-0">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Vigencia</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ofertas as $oferta)
                        @php $situacion = $oferta->situacion(); @endphp
                        <tr>
                            <td><strong>{{ $oferta->producto->nombre }}</strong></td>
                            <td>{{ $oferta->tipo }}</td>
                            <td>
                                {{-- Precio normal tachado + precio de oferta --}}
                                <del class="text-muted small">S/ {{ number_format($oferta->producto->precio, 2) }}</del>
                                <strong class="ms-1">S/ {{ $oferta->precio_oferta }}</strong>
                            </td>
                            <td>{{ $oferta->fecha_inicio->format('d/m/Y') }} – {{ $oferta->fecha_fin->format('d/m/Y') }}</td>
                            <td><span class="badge text-bg-{{ $colores[$situacion] }}">{{ $situacion }}</span></td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('admin.ofertas.edit', $oferta) }}" class="btn btn-sm btn-outline-primary btn-icono" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                {{-- Desactivar: solo aparece si la oferta está activa --}}
                                @if ($oferta->estado)
                                    <form method="POST" action="{{ route('admin.ofertas.destroy', $oferta) }}" class="d-inline"
                                          onsubmit="return confirm('¿Desactivar la oferta de {{ $oferta->producto->nombre }}?')">
                                        @csrf
                                        @method('DELETE')
                                       <button type="submit" class="btn btn-sm btn-outline-danger btn-icono" title="Desactivar">
                                           <i class="bi bi-slash-circle"></i>
                                       </button>
                                   </form>
                               @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No hay ofertas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection