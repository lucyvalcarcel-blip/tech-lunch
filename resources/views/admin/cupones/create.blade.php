@extends('layouts.admin')
@section('titulo', 'Nuevo cupón')
@section('subtitulo', 'Define el código, el porcentaje de descuento y las fechas.')
@section('contenido')
    <div class="tarjeta p-4">
        <form method="POST" action="{{ route('admin.cupones.store') }}">
            @csrf

            @include('admin.cupones.formulario')

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-tl-amarillo">
                    <i class="bi bi-check-circle me-1"></i> Guardar cupón
                </button>
                <a href="{{ route('admin.cupones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection