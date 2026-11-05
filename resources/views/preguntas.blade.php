<x-layout>
    <x-slot:titulo>Preguntas frecuentes</x-slot>

    {{-- Cabecera --}}
    <section class="satin-azul text-white py-5">
        <div class="container">
            <h1 class="fw-bold mb-2">Preguntas frecuentes</h1>
            <p class="mb-0" style="opacity:.9">Resolvemos tus dudas sobre pedidos, pagos y delivery.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container" style="max-width: 820px">

            <div class="accordion" id="acordeonPreguntas">
                @foreach ($preguntas as $item)
                    <div class="accordion-item tarjeta mb-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} fw-semibold"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#pregunta{{ $loop->index }}">
                                {{ $item['pregunta'] }}
                            </button>
                        </h2>
                        <div id="pregunta{{ $loop->index }}"
                             class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                             data-bs-parent="#acordeonPreguntas">
                            <div class="accordion-body text-gris">
                                {{ $item['respuesta'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ¿Otra duda? --}}
            <div class="tarjeta p-4 text-center mt-4">
                <h2 class="h5 fw-bold mb-2">¿No encontraste tu respuesta?</h2>
                <p class="text-gris mb-3">Revisa nuestros datos de contacto o acércate al cafetín.</p>
                <a href="{{ route('contacto') }}" class="btn btn-tl-amarillo">
                    <i class="bi bi-chat-dots me-1"></i> Ir a Contacto
                </a>
            </div>

        </div>
    </section>
</x-layout>