@extends('layouts.admin')

@section('titulo', 'Nueva oferta')
@section('subtitulo', 'Elige el producto, el precio rebajado y las fechas.')

@section('contenido')
    <div class="tarjeta p-4">
        <form method="POST" action="{{ route('admin.ofertas.store') }}">
            @csrf

            @include('admin.ofertas.formulario')

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-tl-amarillo">
                    <i class="bi bi-check-circle me-1"></i> Guardar oferta
                </button>
                <a href="{{ route('admin.ofertas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection