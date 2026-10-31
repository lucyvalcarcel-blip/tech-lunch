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
                <li class="nav-item"><a class="nav-link" href="#">Menú</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Mis pedidos</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <a href="#" class="btn btn-blanco position-relative" aria-label="Carrito">
                    <i class="bi bi-cart3"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill carrito-contador">0</span>
                </a>
                <a href="#" class="btn btn-tl-amarillo">
                    <i class="bi bi-person-circle me-1"></i> Iniciar sesión
                </a>
            </div>
        </div>
    </div>
</nav>