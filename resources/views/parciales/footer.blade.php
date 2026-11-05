<footer class="footer-tl satin-noche">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-5">
                <a class="logo mb-3" href="{{ route('inicio') }}">
                    <span class="logo-icono"><i class="bi bi-cup-hot-fill"></i></span>
                    <span class="logo-texto">
                        <strong>TECH-<span>LUNCH</span></strong>
                        <small>Astrid Catering · Tecsup Ate</small>
                    </span>
                </a>
                <p class="small mb-0 opacity-75">Reserva tu comida, paga en línea y recógela en el cafetín o recíbela en tu aula, sin hacer cola.</p>
            </div>
            <div class="col-6 col-md-3">
                <h6 class="text-white mb-3">Navegación</h6>
                <ul class="list-unstyled small d-grid gap-2 mb-0">
                    <li><a href="#">Menú</a></li>
                    <li><a href="#">Ofertas</a></li>
                    <li><a href="#">Mis pedidos</a></li>
                    <li><a href="{{ route('acerca-de') }}">Quiénes somos</a></li>
                    <li><a href="{{ route('preguntas') }}">Preguntas frecuentes</a></li>
                    <li><a href="{{ route('contacto') }}">Contacto</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4">
                <h6 class="text-white mb-3">Horario de atención</h6>
                <x-info-cafetin compacto />
            </div>
        </div>
        <hr class="border-light opacity-25 my-4">
        <p class="text-center small mb-0 opacity-75">&copy; {{ date('Y') }} {{ $tienda }} · Grupo 1 · Desarrollo de Aplicaciones en Internet</p>
    </div>
</footer>