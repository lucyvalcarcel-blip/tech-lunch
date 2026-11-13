<x-layout>
    <x-slot:titulo>Inicio</x-slot>

    {{-- PORTADA --}}
    <header class="hero satin-azul">
        <span class="hero-burbuja" style="width:380px;height:380px;top:-120px;right:-80px"></span>
        <span class="hero-burbuja" style="width:220px;height:220px;bottom:-60px;left:-40px"></span>
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="insignia insignia-oferta mb-3"><i class="bi bi-lightning-charge-fill me-1"></i> Nuevo en Tecsup</span>
                    <h1 class="mb-3">Pide tu almuerzo <span>sin hacer cola</span></h1>
                    <p class="lead mb-4">Elige del menú del cafetín, paga con Yape o Plin y recógelo listo o recíbelo en tu aula.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#" class="btn btn-tl-amarillo btn-lg"><i class="bi bi-journal-text me-2"></i>Ver menú</a>
                        <a href="#como-funciona" class="btn btn-blanco btn-lg">Cómo funciona</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-pedido p-4 mx-auto" style="max-width:420px">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <strong class="titulo">Tu pedido</strong>
                            <span class="insignia estado-preparacion">Confirmado</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="producto-img producto-mini img-almuerzo"><i class="bi bi-egg-fried"></i></div>
                            <div class="flex-grow-1">
                                <strong class="d-block">Menú del día</strong>
                                <small class="text-gris">Sopa + segundo + refresco</small>
                            </div>
                            <span class="fw-semibold">x2</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-gris d-block">Entrega</small>
                                <strong><i class="bi bi-geo-alt-fill text-azul"></i> Pabellón B · Aula 204</strong>
                            </div>
                            <span class="precio">S/ 22.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- CÓMO FUNCIONA --}}
    <section id="como-funciona" class="container py-5">
        <div class="text-center mb-5">
            <h2 class="seccion-titulo d-inline-block">¿Cómo funciona?</h2>
        </div>
        <div class="row g-4">
            @foreach ($pasos as $paso)
                <div class="col-md-4">
                    <div class="tarjeta tarjeta-hover p-4 h-100 text-center">
                        <div class="icono-circulo {{ $paso['color'] }} mx-auto mb-3"><i class="bi {{ $paso['icono'] }}"></i></div>
                        <h3 class="h5">{{ $paso['titulo'] }}</h3>
                        <p class="text-gris mb-0">{{ $paso['texto'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- OFERTAS DEL DÍA --}}
   <section id="ofertas" class="container pb-5">
        <h2 class="seccion-titulo mb-4">Destacados del día</h2>
        <div class="row g-4">
            @forelse ($destacados as $producto)
                <div class="col-md-4 col-lg-3">
                    <div class="tarjeta tarjeta-hover h-100">
                        <div class="producto-img {{ $producto->categoria->clase_imagen }}">
                            <span class="insignia insignia-oferta position-absolute top-0 start-0 m-3">{{ $producto->categoria->nombre }}</span>
                            <i class="bi {{ $producto->categoria->icono }}"></i>
                        </div>
                        <div class="p-4">
                            <h3 class="h5 mb-1">{{ $producto->nombre }}</h3>
                            <p class="text-gris small mb-3">{{ $producto->descripcion }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="precio">S/ {{ number_format($producto->precio, 2) }}</span>
                                <a href="#" class="btn btn-tl-amarillo btn-sm"><i class="bi bi-plus-lg"></i> Agregar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gris">Por ahora no hay productos destacados.</p>
            @endforelse
        </div>
    </section>

    {{-- CATEGORÍAS --}}
    <section class="container pb-5">
        <h2 class="seccion-titulo mb-4">Categorías</h2>
        <div class="row g-3">
            @foreach ($categorias as $categoria)
                <div class="col-6 col-md-3">
                    <a href="#" class="categoria tarjeta tarjeta-hover d-flex align-items-center gap-3 p-3">
                        <span class="icono-circulo {{ $categoria->clase_imagen }}"><i class="bi {{ $categoria->icono }}"></i></span>
                        <span>
                            <strong class="d-block">{{ $categoria->nombre }}</strong>
                            <small class="text-gris">{{ $categoria->productos_count }} productos</small>
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- LLAMADO A LA ACCIÓN --}}
    <section class="container pb-5">
        <div class="satin-amarillo p-4 p-md-5 d-md-flex align-items-center justify-content-between gap-4" style="border-radius:24px">
            <div>
                <h2 class="h3 mb-2">¿Tienes clase hasta la 1:00 p. m.?</h2>
                <p class="mb-md-0">Haz tu pedido antes y lo recibes en tu aula apenas salgas.</p>
            </div>
            <a href="#" class="btn btn-tl btn-lg flex-shrink-0"><i class="bi bi-bag-plus me-2"></i>Hacer mi pedido</a>
        </div>
    </section>
</x-layout>