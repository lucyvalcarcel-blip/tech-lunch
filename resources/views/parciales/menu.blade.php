<nav class="navbar navbar-expand-lg navbar-tl sticky-top py-2">
    <div class="container">
        <a class="logo navbar-brand" href="{{ route('inicio') }}">
            <span class="logo-icono"><i class="bi bi-cup-hot-fill"></i></span>
            <span class="logo-texto">
                <strong>TECH-<span>LUNCH</span></strong>
                <small>Astrid Catering · Tecsup Ate</small>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inicio') ? 'active' : '' }}" href="{{ route('inicio') }}">Inicio</a>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}" href="{{ Route::has('menu') ? route('menu') : '#' }}">Menú</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('inicio') }}#ofertas">Ofertas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ Route::has('pedidos.index') ? route('pedidos.index') : '#' }}">Mis pedidos</a></li>
            </ul>

            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <a href="{{ Route::has('carrito.index') ? route('carrito.index') : '#' }}" class="btn btn-blanco position-relative" aria-label="Carrito">
                    <i class="bi bi-cart3"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill carrito-contador">{{ array_sum(session('carrito', [])) }}</span>
                </a>

                {{-- Visitante: sin sesión --}}
                @guest
                    <a href="{{ route('login') }}" class="btn btn-tl-amarillo">
                        <i class="bi bi-person-circle me-1"></i> Iniciar sesión
                    </a>
                @endguest

                {{-- Usuario con sesión --}}
                @auth
                    {{-- Solo el administrador ve el acceso al panel --}}
                    @role('administrador')
                        <a href="{{ route('admin.categorias.index') }}" class="btn btn-blanco">
                            <i class="bi bi-speedometer2 me-1"></i> Panel
                        </a>
                    @endrole

                    <a href="{{ Route::has('perfil') ? route('perfil') : '#' }}" class="btn btn-blanco">
                        <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-tl-amarillo">
                            <i class="bi bi-box-arrow-right me-1"></i> Salir
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>