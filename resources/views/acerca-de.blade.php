<x-layout>
    <x-slot:titulo>Quiénes somos</x-slot>

    {{-- Cabecera --}}
    <section class="satin-azul text-white py-5">
        <div class="container">
            <h1 class="fw-bold mb-2">Quiénes somos</h1>
            <p class="mb-0" style="opacity:.9">Conoce {{ $tienda }}, el sistema de pedidos del cafetín de Tecsup Ate.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">

            {{-- Qué es TECH-LUNCH --}}
            <div class="row g-4 align-items-center mb-5">
                <div class="col-lg-7">
                    <h2 class="h3 fw-bold mb-3">¿Qué es {{ $tienda }}?</h2>
                    <p>
                        {{ $tienda }} es la página web del cafetín <strong>Astrid Catering</strong>.
                        Con ella, estudiantes, docentes y personal de Tecsup pueden ver el menú,
                        hacer su pedido y pagarlo con Yape o Plin, sin hacer cola.
                    </p>
                    <p class="mb-0">
                        Después de confirmar tu pedido, lo recoges listo en el cafetín
                        con tu código de pedido.
                    </p>
                </div>
                <div class="col-lg-5">
                    <x-info-cafetin />
                </div>
            </div>

            {{-- Lo que ofrecemos --}}
            <h2 class="h3 fw-bold mb-4 text-center">Lo que te ofrecemos</h2>
            <div class="row g-4 mb-5">
                @foreach ($valores as $valor)
                    <div class="col-md-4">
                        <div class="tarjeta p-4 h-100 text-center">
                            <span class="icono-circulo satin-amarillo mb-3">
                                <i class="bi {{ $valor['icono'] }}"></i>
                            </span>
                            <h3 class="h5 fw-bold">{{ $valor['titulo'] }}</h3>
                            <p class="text-gris mb-0">{{ $valor['texto'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Equipo --}}
            <div class="tarjeta p-4">
                <h2 class="h4 fw-bold mb-1">Equipo de desarrollo</h2>
                <p class="text-gris">Grupo 1 · Desarrollo de Aplicaciones en Internet · Tecsup</p>
                <ul class="list-unstyled row g-2 mb-0">
                    @foreach ($equipo as $integrante)
                        <li class="col-sm-6">
                            <i class="bi bi-person-circle text-azul me-2"></i>{{ $integrante }}
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </section>
</x-layout>