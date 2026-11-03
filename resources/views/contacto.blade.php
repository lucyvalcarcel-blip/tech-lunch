<x-layout>
    <x-slot:titulo>Contacto</x-slot>

    <header class="cabecera-pagina satin-azul">
        <div class="container">
            <h1 class="h2 mb-1">Contacto</h1>
            <p class="mb-0 opacity-75">¿Tienes dudas sobre tu pedido? Aquí encuentras cómo ubicarnos.</p>
        </div>
    </header>

    <main class="container py-5">
        <div class="row g-4">
            <div class="col-lg-6">
                <x-info-cafetin class="h-100" />
            </div>
            <div class="col-lg-6">
                <div class="tarjeta p-4 h-100">
                    <h2 class="h5 mb-3">¿Cómo te atendemos?</h2>
                    <p class="text-gris">Haz tu pedido desde la web y elige si lo recoges en el cafetín o si te lo llevamos a tu pabellón y aula.</p>
                    <ul class="text-gris mb-4">
                        <li>Para dudas sobre un pedido, acércate al cafetín con tu <strong>código de pedido</strong>.</li>
                        <li>Si elegiste delivery, el personal te llamará al <strong>celular</strong> que registraste.</li>
                        <li>Revisa siempre el estado en <strong>Mis pedidos</strong>.</li>
                    </ul>
                    <a href="#" class="btn btn-tl-amarillo"><i class="bi bi-journal-text me-2"></i>Ver menú</a>
                </div>
            </div>
        </div>
    </main>
</x-layout>