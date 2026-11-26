@extends('layouts.admin')

@section('titulo', 'Cupones')
@section('subtitulo', 'Códigos de descuento de un solo uso.')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.cupones.create') }}" class="btn btn-tl-amarillo">
            <i class="bi bi-plus-circle me-1"></i> Nuevo cupón
        </a>
    </div>

    {{-- Color del badge según el estado --}}
    @php
        $colores = [
            'Vigente' => 'success',
            'Programado' => 'info',
            'Vencido' => 'secondary',
            'Usado' => 'warning',
            'Inactivo' => 'danger',
        ];
    @endphp

    <div class="tarjeta tabla-caja">
        <div class="table-responsive">
            <table class="table tabla-tl mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th class="text-center">Descuento</th>
                        <th>Vigencia</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cupones as $cupon)
                        @php $situacion = $cupon->situacion(); @endphp
                        <tr>
                            <td><strong class="font-monospace">{{ $cupon->codigo }}</strong></td>
                            <td>{{ $cupon->descripcion ?? '—' }}</td>
                            <td class="text-center">{{ $cupon->porcentaje }} %</td>
                            <td>{{ $cupon->fecha_inicio->format('d/m/Y') }} – {{ $cupon->fecha_fin->format('d/m/Y') }}</td>
                            <td><span class="badge text-bg-{{ $colores[$situacion] }}">{{ $situacion }}</span></td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('admin.cupones.edit', $cupon) }}" class="btn btn-sm btn-outline-primary btn-icono" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                {{-- El botón Desactivar se agrega en el Paso 5 --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No hay cupones registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection