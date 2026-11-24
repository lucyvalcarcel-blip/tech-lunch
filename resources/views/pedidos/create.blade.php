<x-layout>
    <x-slot:titulo>Confirmar pedido</x-slot>

    <div class="container py-5">
        <h1 class="seccion-titulo h2 mb-4">Confirmar pedido</h1>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('pedidos.store') }}">
            @csrf

            <div class="row g-4">
                <div class="col-lg-8">

                    {{-- 1. TIPO DE ENTREGA --}}
                    <div class="tarjeta p-4 mb-4">
                        <h2 class="h5 mb-3"><span class="insignia insignia-oferta me-2">1</span>Tipo de entrega</h2>

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
                                        <small class="text-gris">+ S/ {{ number_format(\App\Models\Pedido::COSTO_DELIVERY, 2) }} · 12:00 a 3:00 p. m.</small>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div id="camposDelivery" class="row g-3 mb-3">
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
                            <div class="col-md-6">
                                <label for="aula" class="form-label">Aula o ambiente</label>
                                <input type="text" id="aula" name="aula" maxlength="50" value="{{ old('aula') }}"
                                       placeholder="Ej.: Aula 204" class="form-control @error('aula') is-invalid @enderror">
                                @error('aula')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="referencia" class="form-label">Referencia (opcional)</label>
                                <input type="text" id="referencia" name="referencia" maxlength="100" value="{{ old('referencia') }}"
                                       placeholder="Ej.: Segundo piso, al lado del laboratorio" class="form-control">
                            </div>
                        </div>

                        <div class="row g-3">
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
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="alert alert-info small mb-0 w-100 py-2" style="border-radius:12px">
                                    <i class="bi bi-alarm me-1"></i><span id="mensajeLimite"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. PAGO (lo mejoramos en el Paso 6) --}}
                    <div class="tarjeta p-4">
                        <h2 class="h5 mb-3"><span class="insignia insignia-oferta me-2">2</span>Método de pago</h2>

                        <div class="mb-3">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="text" id="celular" name="celular" maxlength="9"
                                   value="{{ old('celular') }}" placeholder="987654321"
                                   class="form-control @error('celular') is-invalid @enderror">
                            @error('celular')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Método de pago</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="yape" value="yape"
                                       @checked(old('metodo_pago', 'yape') === 'yape')>
                                <label class="form-check-label" for="yape">Yape</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="plin" value="plin"
                                       @checked(old('metodo_pago') === 'plin')>
                                <label class="form-check-label" for="plin">Plin</label>
                            </div>
                        </div>

                        <div>
                            <label for="numero_operacion" class="form-label">Número de operación</label>
                            <input type="text" id="numero_operacion" name="numero_operacion" maxlength="20"
                                   value="{{ old('numero_operacion') }}" placeholder="Lo encuentras en tu app de Yape o Plin"
                                   class="form-control @error('numero_operacion') is-invalid @enderror">
                            @error('numero_operacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- RESUMEN --}}
                <div class="col-lg-4">
                    <div class="tarjeta p-4">
                        <h2 class="h5 mb-3">Resumen del pedido</h2>
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
                        <div id="filaDelivery" class="d-flex justify-content-between mb-2">
                            <span class="text-gris">Delivery</span>
                            <span>S/ {{ number_format(\App\Models\Pedido::COSTO_DELIVERY, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <strong>Total</strong>
                            <span id="totalPagar" class="precio fs-4">S/ {{ number_format($total, 2) }}</span>
                        </div>
                        <button type="submit" class="btn btn-tl btn-lg w-100">
                            <i class="bi bi-check2-circle me-1"></i> Confirmar pedido
                        </button>
                        <p class="small text-gris text-center mt-3 mb-0">
                            Si no estás a la hora límite, el pedido se marca como <strong>No llegó</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Solo muestra y calcula en pantalla. El total real lo calcula Laravel al guardar.
        const subtotal = {{ $total }};
        const costoDelivery = {{ \App\Models\Pedido::COSTO_DELIVERY }};
        const minutosLimite = {{ \App\Models\Pedido::MINUTOS_LIMITE }};

        function actualizarEntrega() {
            const esDelivery = document.querySelector('input[name="tipo_entrega"]:checked').value === 'delivery';

            document.getElementById('camposDelivery').style.display = esDelivery ? 'flex' : 'none';
            document.getElementById('filaDelivery').style.setProperty('display', esDelivery ? 'flex' : 'none', 'important');
            document.getElementById('totalPagar').innerText = 'S/ ' + (subtotal + (esDelivery ? costoDelivery : 0)).toFixed(2);

            // Hora elegida + 10 minutos
            let [h, m] = document.getElementById('hora').value.split(':').map(Number);
            m += minutosLimite;
            if (m >= 60) { m -= 60; h += 1; }
            const limite = (h > 12 ? h - 12 : h) + ':' + String(m).padStart(2, '0') + ' p. m.';

            document.getElementById('mensajeLimite').innerHTML =
                (esDelivery ? 'Te esperamos en tu aula hasta las ' : 'Recógelo en el cafetín hasta las ')
                + '<strong>' + limite + '</strong> (' + minutosLimite + ' min después de la hora).';
        }

        document.querySelectorAll('input[name="tipo_entrega"]').forEach(radio => radio.addEventListener('change', actualizarEntrega));
        document.getElementById('hora').addEventListener('change', actualizarEntrega);
        actualizarEntrega();
    </script>
</x-layout>