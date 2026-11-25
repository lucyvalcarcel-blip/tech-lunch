@extends('layouts.admin')

@section('titulo', 'Editar oferta')
@section('subtitulo', 'Modifica el precio, las fechas o el estado de la oferta.')

@section('contenido')
    <div class="tarjeta p-4">
        <form method="POST" action="{{ route('admin.ofertas.update', $oferta) }}">
            @csrf
            @method('PUT')

            @include('admin.ofertas.formulario')

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-tl-amarillo">
                    <i class="bi bi-check-circle me-1"></i> Guardar cambios
                </button>
                <a href="{{ route('admin.ofertas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection