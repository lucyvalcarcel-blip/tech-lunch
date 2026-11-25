
{{-- Precio de un producto. Si tiene oferta hoy: precio normal tachado + precio de oferta. Recibe $producto --}}
@if ($producto->ofertaVigente)
    <del class="text-muted small">S/ {{ number_format($producto->precio, 2) }}</del>
    <strong class="text-danger ms-1">S/ {{ number_format($producto->ofertaVigente->precio_oferta, 2) }}</strong>
    <span class="badge text-bg-danger ms-1">{{ $producto->ofertaVigente->tipo }}</span>
@else
    <strong>S/ {{ number_format($producto->precio, 2) }}</strong>
@endif