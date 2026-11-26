@extends('layouts.admin')
@section('titulo', 'Editar cupón')
@section('subtitulo', 'Modifica el descuento, las fechas o si el cupón está activo.')
@section('contenido')
    <div class="tarjeta p-4">
        <form method="POST" action="{{ route('admin.cupones.update', $cupon) }}">
            @csrf
            @method('PUT')

            @include('admin.cupones.formulario')

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-tl-amarillo">
                    <i class="bi bi-check-circle me-1"></i> Guardar cambios
                </button>
                <a href="{{ route('admin.cupones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection