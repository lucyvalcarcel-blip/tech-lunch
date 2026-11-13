@extends('layouts.admin')

@section('titulo', 'Nuevo producto')
@section('subtitulo', 'Agrega un plato o bebida al menú del cafetín.')

@section('contenido')
    <div class="tarjeta p-4" style="max-width: 640px">
        <form action="{{ route('admin.productos.store') }}" method="POST">
            @csrf

            @include('admin.productos.formulario')

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-tl-amarillo">
                    <i class="bi bi-save me-1"></i> Guardar
                </button>
                <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection