<x-layout>
    <x-slot:titulo>Menú</x-slot>
    <header class="cabecera-pagina satin-azul">
        <div class="container">
            <h1 class="h2 mb-1">Nuestro menú</h1>
            <p class="mb-0">Elige tus comidas y bebidas. Revisa el stock disponible antes de pedir.</p>
        </div>
    </header>

    <div class="container py-4">
        @foreach ($categorias as $categoria)
            <section class="mb-5">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="icono-circulo {{ $categoria->clase_imagen }}" style="width:46px;height:46px;font-size:1.2rem">
                        <i class="bi {{ $categoria->icono }}"></i>
                    </span>
                    <h2 class="h4 mb-0">{{ $categoria->nombre }}</h2>
                </div>

                <div class="row g-4">
                    @forelse ($categoria->productos as $producto)
                        <div class="col-sm-6 col-lg-3">
                            <div class="tarjeta tarjeta-hover h-100 {{ $producto->stock === 0 ? 'agotado' : '' }}">
                                <div class="producto-img {{ $categoria->clase_imagen }}">
                                    <i class="bi {{ $categoria->icono }}"></i>
                                </div>

                                <div class="p-3">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                        <h3 class="h6 mb-0">{{ $producto->nombre }}</h3>

                                        @if ($producto->stock === 0)
                                            <span class="insignia insignia-agotado">Agotado</span>
                                        @elseif ($producto->stock <= 5)
                                            <span class="insignia insignia-poco">Quedan {{ $producto->stock }}</span>
                                        @else
                                            <span class="insignia insignia-stock">Stock: {{ $producto->stock }}</span>
                                        @endif
                                    </div>

                                    <p class="text-gris small mb-3">{{ $producto->descripcion }}</p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="precio">S/ {{ $producto->precio }}</span>

                                        @if ($producto->stock === 0)
                                            <button class="btn btn-light btn-sm" disabled>Sin stock</button>
                                        @else
                                            <button type="button" class="btn btn-tl-amarillo btn-sm">
                                                <i class="bi bi-plus-lg"></i> Agregar
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gris">Todavía no hay productos en esta categoría.</p>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
</x-layout>