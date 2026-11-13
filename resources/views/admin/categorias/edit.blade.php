@extends('layouts.admin')

@section('titulo', 'Editar categoría')
@section('subtitulo', $categoria->nombre)

@section('contenido')
    <div class="tarjeta p-4" style="max-width: 640px">
        <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.categorias.formulario')

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-tl-amarillo">
                    <i class="bi bi-save me-1"></i> Guardar cambios
                </button>
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection