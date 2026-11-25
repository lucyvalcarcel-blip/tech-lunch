{{-- Campos compartidos por create y edit. Recibe $oferta y $productos --}}
<div class="row g-3">

    {{-- Producto: se elige por NOMBRE, pero se guarda el id --}}
    <div class="col-md-6">
        <label for="producto_id" class="form-label">Producto</label>
        <select id="producto_id" name="producto_id" class="form-select @error('producto_id') is-invalid @enderror">
            <option value="">Elige un producto</option>
            @foreach ($productos as $producto)
                <option value="{{ $producto->id }}" @selected(old('producto_id', $oferta->producto_id) == $producto->id)>
                    {{ $producto->nombre }} (S/ {{ number_format($producto->precio, 2) }})
                </option>
            @endforeach
        </select>
        @error('producto_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Tipo: sale de la constante Oferta::TIPOS --}}
    <div class="col-md-6">
        <label for="tipo" class="form-label">Tipo de oferta</label>
        <select id="tipo" name="tipo" class="form-select @error('tipo') is-invalid @enderror">
            <option value="">Elige un tipo</option>
            @foreach (\App\Models\Oferta::TIPOS as $tipo)
                <option value="{{ $tipo }}" @selected(old('tipo', $oferta->tipo) === $tipo)>{{ $tipo }}</option>
            @endforeach
        </select>
        @error('tipo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Precio de oferta --}}
    <div class="col-md-4">
        <label for="precio_oferta" class="form-label">Precio de oferta (S/)</label>
        <input type="number" step="0.10" min="0" id="precio_oferta" name="precio_oferta"
               value="{{ old('precio_oferta', $oferta->precio_oferta) }}"
               class="form-control @error('precio_oferta') is-invalid @enderror">
        @error('precio_oferta') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Fechas: el input date necesita el formato Y-m-d --}}
    <div class="col-md-4">
        <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio"
               value="{{ old('fecha_inicio', $oferta->fecha_inicio?->format('Y-m-d')) }}"
               class="form-control @error('fecha_inicio') is-invalid @enderror">
        @error('fecha_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label for="fecha_fin" class="form-label">Fecha de fin</label>
        <input type="date" id="fecha_fin" name="fecha_fin"
               value="{{ old('fecha_fin', $oferta->fecha_fin?->format('Y-m-d')) }}"
               class="form-control @error('fecha_fin') is-invalid @enderror">
        @error('fecha_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Estado: interruptor activa / inactiva --}}
    <div class="col-12">
        <div class="form-check form-switch">
            <input type="checkbox" id="estado" name="estado" value="1" class="form-check-input"
                   @checked(old('estado', $oferta->estado))>
            <label for="estado" class="form-check-label">Oferta activa</label>
        </div>
    </div>
</div>