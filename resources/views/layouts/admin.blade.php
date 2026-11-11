<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') | Panel {{ $tienda }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @php
        $esAdminPersonal = auth()->user()->hasRole(['administrador', 'personal']);

        $opciones = [
            ['ruta' => 'admin.pedidos.index', 'icono' => 'bi-receipt', 'texto' => 'Pedidos'],
        ];

        if ($esAdminPersonal) {
            $opciones[] = ['ruta' => 'admin.productos.index', 'icono' => 'bi-box-seam', 'texto' => 'Productos'];
            $opciones[] = ['ruta' => 'admin.categorias.index', 'icono' => 'bi-tags', 'texto' => 'Categorías'];
            $opciones[] = ['ruta' => 'admin.ofertas.index', 'icono' => 'bi-percent', 'texto' => 'Ofertas'];
            $opciones[] = ['ruta' => 'admin.puntos.index', 'icono' => 'bi-geo-alt', 'texto' => 'Puntos de entrega'];
        }
    @endphp

    <div class="d-flex">

        {{-- ===== MENÚ LATERAL ===== --}}
        <aside class="admin-sidebar satin-noche d-flex flex-column p-3">
            <a class="logo mb-4 px-2 pt-2" href="{{ route('inicio') }}">
                <span class="logo-icono"><i class="bi bi-cup-hot-fill"></i></span>
                <span class="logo-texto">
                    <strong>TECH-<span>LUNCH</span></strong>
                    <small>Panel del cafetín</small>
                </span>
            </a>

            <p class="menu-titulo mb-2">Gestión</p>
            <nav class="nav flex-column gap-1">
                @foreach ($opciones as $opcion)
                    @php
                        $existe = Route::has($opcion['ruta']);
                        $activa = request()->routeIs(str_replace('.index', '.*', $opcion['ruta']));
                    @endphp
                    <a class="nav-link {{ $activa ? 'active' : '' }}"
                       href="{{ $existe ? route($opcion['ruta']) : '#' }}">
                        <i class="bi {{ $opcion['icono'] }}"></i> {{ $opcion['texto'] }}
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto">
                <a class="nav-link" href="{{ route('inicio') }}"><i class="bi bi-shop"></i> Ver tienda</a>
                <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</a>
            </div>
        </aside>

        {{-- ===== CONTENIDO ===== --}}
        <div class="admin-contenido">
            <header class="admin-barra d-flex align-items-center justify-content-between px-4 py-3">
                <div>
                    <h1 class="h4 mb-0">@yield('titulo')</h1>
                    <small class="text-gris">@yield('subtitulo')</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar satin-amarillo">AD</span>
                    <div class="lh-sm d-none d-sm-block">
                        <strong class="small d-block">{{ auth()->user()->name ?? 'Administrador' }}</strong>
                        <small class="text-gris">Astrid Catering</small>
                    </div>
                </div>
            </header>

            <main class="p-4">
                {{-- Mensaje de éxito después de guardar (lo usan todos los CRUD) --}}
                @if (session('exito'))
                    <div class="alert alert-success d-flex align-items-center gap-2" style="border-radius:14px">
                        <i class="bi bi-check-circle-fill"></i> {{ session('exito') }}
                    </div>
                @endif

                @yield('contenido')
            </main>
        </div>
    </div>
</body>

</html>