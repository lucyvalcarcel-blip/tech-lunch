{{-- ============================================================
     CONFIRMAR PEDIDO (pedidos/create)
     El cliente elige: 1) tipo de entrega y 2) método de pago.
     A la derecha ve el resumen y confirma.
     Datos que llegan del controlador (PedidoController@create):
       $productos, $carrito, $total, $zonas
     ============================================================ --}}
<x-layout>
    <x-slot:titulo>Confirmar pedido</x-slot>

    <div class="container py-5">
        <h1 class="seccion-titulo h2 mb-4">Confirmar pedido</h1>

        {{-- Mensaje de error general (por ejemplo: sin stock o tarjeta rechazada) --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- El formulario envuelve TODO (entrega, pago y botón) para enviarlo junto.
             El id "formPedido" lo usa el script para mostrar "Procesando pago..." --}}
        <form id="formPedido" method="POST" action="{{ route('pedidos.store') }}">
            @csrf

            <div class="row g-4">

                {{-- ===================== COLUMNA IZQUIERDA ===================== --}}
                <div class="col-lg-8">

                    {{-- ---------- 1. TIPO DE ENTREGA ---------- --}}
                    <div class="tarjeta p-4 mb-4">
                        <h2 class="h5 mb-3"><span class="insignia insignia-oferta me-2">1</span>Tipo de entrega</h2>

                        {{-- Las 2 opciones: recojo o delivery.
                             old() recuerda lo elegido si la validación falla --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="opcion">
                                    <input type="radio" name="tipo_entrega" value="recojo"
                                           @checked(old('tipo_entrega', 'recojo') === 'recojo')>
                                    <span class="icono-circulo satin-azul" style="width:48px;height:48px;font-size:1.3rem"><i class="bi bi-shop"></i></span>
                                    <span><strong class="d-block">Recojo en cafetín</strong><small class="text-gris">Sin costo adicional</small></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="opcion">
                                    <input type="radio" name="tipo_entrega" value="delivery"
                                           @checked(old('tipo_entrega') === 'delivery')>
                                    <span class="icono-circulo satin-amarillo" style="width:48px;height:48px;font-size:1.3rem"><i class="bi bi-truck"></i></span>
                                    <span>
                                        <strong class="d-block">Delivery en el campus</strong>
                                        {{-- El costo sale de la constante del modelo: un solo lugar para cambiarlo --}}
                                        <small class="text-gris">+ S/ {{ number_format(\App\Models\Pedido::COSTO_DELIVERY, 2) }} · 12:00 a 3:00 p. m.</small>
                                    </span>
                                </label>
                            </div>
                        </div>

                        {{-- Campos SOLO para delivery (el script los oculta si es recojo) --}}
                        <div id="camposDelivery" class="row g-3 mb-3">

                            {{-- Zona: lista que viene de la tabla "zonas" (ZonaSeeder). Se envía el id --}}
                            <div class="col-md-6">
                                <label for="zona_id" class="form-label">Zona</label>
                                <select id="zona_id" name="zona_id" class="form-select @error('zona_id') is-invalid @enderror">
                                    <option value="">[ Seleccione ]</option>
                                    @foreach ($zonas as $zona)
                                        <option value="{{ $zona->id }}" @selected(old('zona_id') == $zona->id)>
                                            {{ $zona->nombre }} · {{ $zona->descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('zona_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Aula: obligatoria con delivery --}}
                            <div class="col-md-6">
                                <label for="aula" class="form-label">Aula o ambiente</label>
                                <input type="text" id="aula" name="aula" maxlength="50" value="{{ old('aula') }}"
                                       placeholder="Ej.: Aula 204" class="form-control @error('aula') is-invalid @enderror">
                                @error('aula')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Referencia: opcional, ayuda al repartidor --}}
                            <div class="col-12">
                                <label for="referencia" class="form-label">Referencia (opcional)</label>
                                <input type="text" id="referencia" name="referencia" maxlength="100" value="{{ old('referencia') }}"
                                       placeholder="Ej.: Segundo piso, al lado del laboratorio" class="form-control">
                            </div>

                            {{-- Hora: las opciones salen de la constante Pedido::HORAS --}}
                            <div class="col-md-6">
                                <label for="hora" class="form-label">Hora</label>
                                <select id="hora" name="hora" class="form-select @error('hora') is-invalid @enderror">
                                    @foreach (\App\Models\Pedido::HORAS as $valor => $texto)
                                        <option value="{{ $valor }}" @selected(old('hora', '12:30') === $valor)>{{ $texto }}</option>
                                    @endforeach
                                </select>
                                @error('hora')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Mensaje del tiempo límite (lo escribe el script):
                             recojo = hasta la hora de cierre; delivery = hora + 10 min --}}
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="alert alert-info small mb-0 w-100 py-2" style="border-radius:12px">
                                    <i class="bi bi-alarm me-1"></i><span id="mensajeLimite"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- fin 1. TIPO DE ENTREGA --}}

                    {{-- ---------- 2. MÉTODO DE PAGO ---------- --}}
                    <div class="tarjeta p-4">
                        <h2 class="h5 mb-3"><span class="insignia insignia-oferta me-2">2</span>Método de pago</h2>

                        {{-- Celular de contacto: se pide SIEMPRE (el repartidor llama si no encuentra al cliente) --}}
                        <div class="mb-3">
                            <label for="celular" class="form-label">Celular de contacto</label>
                            <input type="text" id="celular" name="celular" maxlength="9" value="{{ old('celular') }}"
                                   placeholder="987654321" class="form-control @error('celular') is-invalid @enderror">
                            @error('celular')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Los 4 métodos en un arreglo: [nombre, detalle, ícono, estilo del círculo] --}}
                        @php
                            $metodos = [
                                'yape'    => ['Yape', 'Pago con QR o número', 'bi-phone', 'background:linear-gradient(135deg,#9B4DCA,#6A1B9A);color:#fff'],
                                'plin'    => ['Plin', 'Pago con QR o número', 'bi-phone', 'background:linear-gradient(135deg,#3DD6C6,#00A19A);color:#fff'],
                                'debito'  => ['Tarjeta de débito', 'Visa o Mastercard', 'bi-credit-card', ''],
                                'credito' => ['Tarjeta de crédito', 'Hasta 6 cuotas', 'bi-credit-card-2-front', ''],
                            ];
                        @endphp

                        {{-- Una tarjeta por método (se dibujan con un solo @foreach) --}}
                        <div class="row g-3 mb-3">
                            @foreach ($metodos as $valor => [$nombre, $detalle, $icono, $estilo])
                                <div class="col-md-6">
                                    <label class="opcion">
                                        <input type="radio" name="metodo_pago" value="{{ $valor }}"
                                               @checked(old('metodo_pago', 'yape') === $valor)>
                                        <span class="icono-circulo {{ $estilo ? '' : ($valor === 'debito' ? 'satin-azul' : 'satin-amarillo') }}"
                                              style="width:48px;height:48px;font-size:1.3rem;{{ $estilo }}"><i class="bi {{ $icono }}"></i></span>
                                        <span><strong class="d-block">{{ $nombre }}</strong><small class="text-gris">{{ $detalle }}</small></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('metodo_pago')
                            <div class="text-danger small mb-2">{{ $message }}</div>
                        @enderror

                        {{-- Campos de YAPE o PLIN (el script los muestra solo con esos métodos) --}}
                        <div id="camposBilletera" class="p-3 rounded-4" style="background:var(--tl-fondo)">
                            <p class="small mb-2">
                                Yapea o plinea el total a <strong>Astrid Catering</strong> y escribe el número de operación de tu comprobante.
                            </p>
                            <label for="numero_operacion" class="form-label">Número de operación</label>
                            <input type="text" id="numero_operacion" name="numero_operacion" maxlength="20"
                                   value="{{ old('numero_operacion') }}" placeholder="Ej.: 08451236"
                                   class="form-control @error('numero_operacion') is-invalid @enderror">
                            @error('numero_operacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campos de TARJETA (débito o crédito). Pago simulado --}}
                        <div id="camposTarjeta" class="p-3 rounded-4" style="background:var(--tl-fondo)">
                            <div class="row g-3">

                                {{-- Titular (se valida, pero NO se guarda) --}}
                                <div class="col-12">
                                    <label for="titular" class="form-label">Nombre del titular</label>
                                    <input type="text" id="titular" name="titular" maxlength="60" value="{{ old('titular') }}"
                                           placeholder="Como aparece en la tarjeta"
                                           class="form-control text-uppercase @error('titular') is-invalid @enderror">
                                    @error('titular')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Número de tarjeta: el script pone espacios y detecta VISA o MASTERCARD.
                                     Se valida con Luhn; solo se guardan los últimos 4 dígitos --}}
                                <div class="col-12">
                                    <label for="numero_tarjeta" class="form-label">Número de tarjeta</label>
                                    <div class="input-group">
                                        <input type="text" id="numero_tarjeta" name="numero_tarjeta" maxlength="19" inputmode="numeric"
                                               value="{{ old('numero_tarjeta') }}" placeholder="0000 0000 0000 0000"
                                               class="form-control @error('numero_tarjeta') is-invalid @enderror">
                                        <span id="marca" class="input-group-text fw-semibold" style="min-width:120px">—</span>
                                        @error('numero_tarjeta')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-gris">Solo se guardan los últimos 4 dígitos.</small>
                                </div>

                                {{-- Vencimiento en formato MM/AA (no puede estar vencida) --}}
                                <div class="col-6 col-md-4">
                                    <label for="vencimiento" class="form-label">Vencimiento</label>
                                    <input type="text" id="vencimiento" name="vencimiento" maxlength="5" placeholder="MM/AA"
                                           value="{{ old('vencimiento') }}" class="form-control @error('vencimiento') is-invalid @enderror">
                                    @error('vencimiento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- CVV: tipo password y SIN old(): nunca se devuelve ni se guarda --}}
                                <div class="col-6 col-md-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="password" id="cvv" name="cvv" maxlength="3" inputmode="numeric" placeholder="123"
                                           class="form-control @error('cvv') is-invalid @enderror">
                                    @error('cvv')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Cuotas: solo con crédito (el script las oculta con débito) --}}
                                <div id="campoCuotas" class="col-md-5">
                                    <label for="cuotas" class="form-label">Cuotas</label>
                                    <select id="cuotas" name="cuotas" class="form-select">
                                        @foreach ([1, 3, 6] as $cuota)
                                            <option value="{{ $cuota }}" @selected(old('cuotas', 1) == $cuota)>
                                                {{ $cuota }} {{ $cuota === 1 ? 'cuota (sin intereses)' : 'cuotas' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <p class="small text-gris mb-0 mt-3"><i class="bi bi-shield-lock me-1"></i>Pago simulado. El CVV nunca se guarda.</p>
                        </div>
                    </div>
                    {{-- fin 2. MÉTODO DE PAGO --}}

                </div>
                {{-- ===================== fin COLUMNA IZQUIERDA ===================== --}}

                {{-- ===================== COLUMNA DERECHA: RESUMEN ===================== --}}
                <div class="col-lg-4">
                    <div class="tarjeta p-4">
                        <h2 class="h5 mb-3">Resumen del pedido</h2>

                        {{-- Productos del carrito: cantidad × nombre y su subtotal --}}
                        @foreach ($productos as $producto)
                            <div class="d-flex justify-content-between small mb-2">
                                <span>{{ $carrito[$producto->id] }} × {{ $producto->nombre }}</span>
                                <span>S/ {{ number_format($producto->precio * $carrito[$producto->id], 2) }}</span>
                            </div>
                        @endforeach
                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-gris">Subtotal</span>
                            <span>S/ {{ number_format($total, 2) }}</span>
                        </div>

                        {{-- Línea del delivery (el script la muestra solo con delivery) --}}
                        <div id="filaDelivery" class="d-flex justify-content-between mb-2">
                            <span class="text-gris">Delivery</span>
                            <span>S/ {{ number_format(\App\Models\Pedido::COSTO_DELIVERY, 2) }}</span>
                        </div>
                        <hr>

                        {{-- Total en pantalla (el script le suma el delivery).
                             El total REAL lo calcula Laravel al guardar --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <strong>Total</strong>
                            <span id="totalPagar" class="precio fs-4">S/ {{ number_format($total, 2) }}</span>
                        </div>

                        {{-- Botón para enviar. El id lo usa el script para "Procesando pago..." --}}
                        <button type="submit" id="botonConfirmar" class="btn btn-tl btn-lg w-100">
                            <i class="bi bi-check2-circle me-1"></i> Confirmar pedido
                        </button>
                        <p class="small text-gris text-center mt-3 mb-0">
                            Si no estás a la hora límite, el pedido se marca como <strong>No llegó</strong>.
                        </p>
                    </div>
                </div>
                {{-- ===================== fin COLUMNA DERECHA ===================== --}}

            </div>
        </form>
    </div>

    <script>
        // ============================================================
        // JAVASCRIPT DE LA PÁGINA
        // Solo MUESTRA, OCULTA y CALCULA en pantalla.
        // Las validaciones y el total real los hace Laravel (store).
        // ============================================================

        // Valores que vienen de PHP (constantes del modelo Pedido)
        const subtotal = {{ $total }};
        const costoDelivery = {{ \App\Models\Pedido::COSTO_DELIVERY }};
        const minutosLimite = {{ \App\Models\Pedido::MINUTOS_LIMITE }};
        const horaCierre = '{{ \App\Models\Pedido::HORA_CIERRE }}';

        // ---------- ENTREGA ----------
        // Muestra u oculta los campos del delivery, suma el costo
        // y escribe el mensaje del tiempo límite
        function actualizarEntrega() {
            const esDelivery = document.querySelector('input[name="tipo_entrega"]:checked').value === 'delivery';

            document.getElementById('camposDelivery').style.display = esDelivery ? 'flex' : 'none';
            document.getElementById('filaDelivery').style.setProperty('display', esDelivery ? 'flex' : 'none', 'important');
            document.getElementById('totalPagar').innerText = 'S/ ' + (subtotal + (esDelivery ? costoDelivery : 0)).toFixed(2);

            // Recojo: se espera hasta la hora de cierre del cafetín
            if (!esDelivery) {
                document.getElementById('mensajeLimite').innerHTML =
                    'Recógelo en el cafetín hasta las <strong>' + aTexto(horaCierre) + '</strong> (hora de cierre).';
                return;
            }

            // Delivery: hora elegida + 10 minutos
            let [h, m] = document.getElementById('hora').value.split(':').map(Number);
            m += minutosLimite;
            if (m >= 60) { m -= 60; h += 1; }

            document.getElementById('mensajeLimite').innerHTML =
                'Te esperamos en tu aula hasta las <strong>' + aTexto(h + ':' + m) + '</strong> (' + minutosLimite + ' min después de la hora).';
        }

        // Convierte '17:00' en '5:00 p. m.'
        function aTexto(hora) {
            let [h, m] = hora.split(':').map(Number);
            return (h > 12 ? h - 12 : h) + ':' + String(m).padStart(2, '0') + ' p. m.';
        }

        // ---------- PAGO ----------
        // Muestra solo los campos del método de pago elegido
        function mostrarPago() {
            const metodo = document.querySelector('input[name="metodo_pago"]:checked').value;
            const esTarjeta = metodo === 'debito' || metodo === 'credito';

            document.getElementById('camposBilletera').style.display = esTarjeta ? 'none' : 'block';
            document.getElementById('camposTarjeta').style.display = esTarjeta ? 'block' : 'none';
            document.getElementById('campoCuotas').style.display = metodo === 'credito' ? 'block' : 'none';
        }

        // Pone espacios cada 4 dígitos y detecta la marca (4 = VISA, 5 = MASTERCARD)
        function formatearTarjeta() {
            const campo = document.getElementById('numero_tarjeta');
            const digitos = campo.value.replace(/\D/g, '').slice(0, 16);
            campo.value = digitos.replace(/(\d{4})(?=\d)/g, '$1 ');

            let marca = '—';
            if (digitos.startsWith('4')) marca = 'VISA';
            else if (digitos.startsWith('5')) marca = 'MASTERCARD';
            document.getElementById('marca').innerText = marca;
        }

        // ---------- EVENTOS: cuándo se ejecuta cada función ----------
        document.querySelectorAll('input[name="tipo_entrega"]').forEach(radio => radio.addEventListener('change', actualizarEntrega));
        document.getElementById('hora').addEventListener('change', actualizarEntrega);
        document.querySelectorAll('input[name="metodo_pago"]').forEach(radio => radio.addEventListener('change', mostrarPago));
        document.getElementById('numero_tarjeta').addEventListener('input', formatearTarjeta);

        // Al enviar: desactiva el botón (evita doble clic) y muestra "Procesando pago..."
        document.getElementById('formPedido').addEventListener('submit', function () {
            const boton = document.getElementById('botonConfirmar');
            boton.disabled = true;
            boton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Procesando pago...';
        });

        // Al cargar la página: deja todo en su estado inicial
        // (también sirve si la validación falló y se volvió con datos)
        actualizarEntrega();
        mostrarPago();
        formatearTarjeta();
    </script>
</x-layout>