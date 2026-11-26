{{-- Campos compartidos por create y edit. Recibe $cupon --}}
<div class="row g-3">

    {{-- Código: se guarda en mayúsculas --}}
    <div class="col-md-6">
        <label for="codigo" class="form-label">Código</label>
        <input type="text" id="codigo" name="codigo" maxlength="20"
               value="{{ old('codigo', $cupon->codigo) }}"
               class="form-control text-uppercase font-monospace @error('codigo') is-invalid @enderror"
               placeholder="Ej: TECSUP20">
        @error('codigo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Porcentaje de descuento --}}
    <div class="col-md-6">
        <label for="porcentaje" class="form-label">Descuento (%)</label>
        <input type="number" id="porcentaje" name="porcentaje" min="1" max="100" step="1"
               value="{{ old('porcentaje', $cupon->porcentaje) }}"
               class="form-control @error('porcentaje') is-invalid @enderror">
        @error('porcentaje') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Descripción (opcional) --}}
    <div class="col-12">
        <label for="descripcion" class="form-label">Descripción <small class="text-muted">(opcional)</small></label>
        <input type="text" id="descripcion" name="descripcion" maxlength="100"
               value="{{ old('descripcion', $cupon->descripcion) }}"
               class="form-control @error('descripcion') is-invalid @enderror"
               placeholder="Ej: Semana de exámenes">
        @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Fechas: el input date necesita el formato Y-m-d --}}
    <div class="col-md-6">
        <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio"
               value="{{ old('fecha_inicio', $cupon->fecha_inicio?->format('Y-m-d')) }}"
               class="form-control @error('fecha_inicio') is-invalid @enderror">
        @error('fecha_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="fecha_fin" class="form-label">Fecha de fin</label>
        <input type="date" id="fecha_fin" name="fecha_fin"
               value="{{ old('fecha_fin', $cupon->fecha_fin?->format('Y-m-d')) }}"
               class="form-control @error('fecha_fin') is-invalid @enderror">
        @error('fecha_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Activo / Inactivo. "Usado" no se elige: lo pone el sistema al pagar --}}
    <div class="col-12">
        <div class="form-check form-switch">
            <input type="checkbox" id="activo" name="activo" value="1" class="form-check-input"
                   @checked(old('activo', $cupon->estado === \App\Models\Cupon::DISPONIBLE))>
            <label for="activo" class="form-check-label">Cupón activo (se puede usar al pagar)</label>
        </div>
    </div>
</div>