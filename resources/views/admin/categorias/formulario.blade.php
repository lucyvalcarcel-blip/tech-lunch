@php
    // Íconos de Bootstrap Icons que el admin puede elegir
    $iconos = [
        'bi-cup-hot' => 'Taza caliente (desayunos)',
        'bi-egg-fried' => 'Plato (almuerzos)',
        'bi-cup-straw' => 'Vaso (bebidas)',
        'bi-basket2' => 'Canasta (snacks)',
        'bi-cake2' => 'Torta (postres)',
        'bi-apple' => 'Fruta',
        'bi-tag' => 'Etiqueta (otros)',
    ];
    $estadoActual = old('estado', $categoria->estado ? '1' : '0');
@endphp

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" id="nombre" name="nombre" maxlength="50"
           class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $categoria->nombre) }}" placeholder="Ej.: Postres">
    @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea id="descripcion" name="descripcion" rows="3"
              class="form-control @error('descripcion') is-invalid @enderror"
              placeholder="Breve descripción de la categoría">{{ old('descripcion', $categoria->descripcion) }}</textarea>
    @error('descripcion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-7">
        <label for="icono" class="form-label">Ícono</label>
        <select id="icono" name="icono" class="form-select">
            @foreach ($iconos as $valor => $texto)
                <option value="{{ $valor }}" @selected(old('icono', $categoria->icono) === $valor)>{{ $texto }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-5">
        <label for="estado" class="form-label">Estado</label>
        <select id="estado" name="estado" class="form-select">
            <option value="1" @selected($estadoActual == '1')>Activa</option>
            <option value="0" @selected($estadoActual == '0')>Inactiva</option>
        </select>
    </div>
</div>