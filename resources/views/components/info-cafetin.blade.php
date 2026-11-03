@props(['compacto' => false])

@php
    $datos = [
        ['icono' => 'bi-geo-alt', 'etiqueta' => 'Ubicación', 'valor' => 'Cafetín de Tecsup, sede Ate'],
        ['icono' => 'bi-clock', 'etiqueta' => 'Horario de atención', 'valor' => 'Lunes a viernes, de 7:00 a. m. a 5:00 p. m.'],
        ['icono' => 'bi-truck', 'etiqueta' => 'Delivery en el campus', 'valor' => 'De 12:00 a 3:00 p. m. (+ S/ 2.00)'],
        ['icono' => 'bi-phone', 'etiqueta' => 'Medios de pago', 'valor' => 'Yape y Plin'],
    ];
@endphp

@if ($compacto)
    <ul class="list-unstyled small d-grid gap-2 mb-0 opacity-75">
        @foreach ($datos as $dato)
            <li><i class="bi {{ $dato['icono'] }} me-2"></i>{{ $dato['valor'] }}</li>
        @endforeach
    </ul>
@else
    <div {{ $attributes->merge(['class' => 'tarjeta p-4']) }}>
        <h2 class="h5 mb-4">Información del cafetín</h2>
        @foreach ($datos as $dato)
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="icono-circulo satin-azul flex-shrink-0" style="width:46px;height:46px;font-size:1.1rem;border-radius:14px">
                    <i class="bi {{ $dato['icono'] }}"></i>
                </span>
                <div>
                    <small class="text-gris d-block">{{ $dato['etiqueta'] }}</small>
                    <strong>{{ $dato['valor'] }}</strong>
                </div>
            </div>
        @endforeach
    </div>
@endif