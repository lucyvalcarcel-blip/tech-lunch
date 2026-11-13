@php
    $destacadoActual = old('destacado', $producto->destacado ? '1' : '0');
    $estadoActual = old('estado', $producto->estado ? '1' : '0');
@endphp

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" id="nombre" name="nombre" maxlength="150"
           class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $producto->nombre) }}" placeholder="Ej.: Causa limeña">
    @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea id="descripcion" name="descripcion" rows="2"
              class="form-control @error('descripcion') is-invalid @enderror"
              placeholder="Breve descripción del producto">{{ old('descripcion', $producto->descripcion) }}</textarea>
    @error('descripcion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <label for="precio" class="form-label">Precio (S/)</label>
        <input type="number" id="precio" name="precio" step="0.10" min="0"
               class="form-control @error('precio') is-invalid @enderror"
               value="{{ old('precio', $producto->precio) }}">
        @error('precio')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-sm-6">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" id="stock" name="stock" min="0"
               class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $producto->stock) }}">
        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="categoria_id" class="form-label">Categoría</label>
    <select id="categoria_id" name="categoria_id"
            class="form-select @error('categoria_id') is-invalid @enderror">
        <option value="">[ Seleccione ]</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id }}"
                @selected(old('categoria_id', $producto->categoria_id) == $categoria->id)>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
    @error('categoria_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6">
        <label for="destacado" class="form-label">¿Destacado en el inicio?</label>
        <select id="destacado" name="destacado" class="form-select">
            <option value="0" @selected($destacadoActual == '0')>No</option>
            <option value="1" @selected($destacadoActual == '1')>Sí</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label for="estado" class="form-label">Estado</label>
        <select id="estado" name="estado" class="form-select">
            <option value="1" @selected($estadoActual == '1')>Activo</option>
            <option value="0" @selected($estadoActual == '0')>Inactivo</option>
        </select>
    </div>
</div>