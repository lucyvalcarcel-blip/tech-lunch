@extends('layouts.admin')
@section('titulo', 'Editar Producto')
@section('subtitulo', 'Actualiza los datos del producto.')
@section('contenido')
<div class="tarjeta p-4" style="max-width: 800px;">
    <form action="{{ route('admin.productos.update', $producto) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del producto</label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select class="form-select @error('categoria_id') is-invalid @enderror" id="categoria_id" name="categoria_id" required>
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="precio" class="form-label">Precio (S/)</label>
                <input type="number" step="0.01" class="form-control @error('precio') is-invalid @enderror" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" required>
                @error('precio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $producto->stock) }}" required>
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Nombre de archivo de imagen (ej: producto.jpg)</label>
            <input type="text" class="form-control @error('imagen') is-invalid @enderror" id="imagen" name="imagen" value="{{ old('imagen', $producto->imagen) }}">
            @error('imagen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="estado" name="estado" value="1" {{ old('estado', $producto->estado) ? 'checked' : '' }}>
            <label class="form-check-label" for="estado">Producto activo</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="destacado" name="destacado" value="1" {{ old('destacado', $producto->destacado) ? 'checked' : '' }}>
            <label class="form-check-label" for="destacado">Marcar como destacado</label>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-tl-amarillo">Actualizar producto</button>
        </div>
    </form>
</div>
@endsection