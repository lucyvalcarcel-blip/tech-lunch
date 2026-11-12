<x-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="tarjeta login-caja">
                    <div class="row g-0">

                        {{-- Panel de color (del prototipo) --}}
                        <div class="col-lg-6 satin-azul login-panel p-4 p-md-5 d-flex flex-column justify-content-center">
                            <h1 class="h2 mb-3">¡Hola de nuevo!</h1>
                            <p class="mb-4" style="opacity:.92">
                                Ingresa para hacer tus pedidos o, si eres parte del personal, atender los pedidos del cafetín.
                            </p>
                            <div class="d-flex gap-4 small" style="opacity:.9">
                                <span><i class="bi bi-person me-1"></i> Clientes</span>
                                <span><i class="bi bi-person-badge me-1"></i> Personal</span>
                                <span><i class="bi bi-gear me-1"></i> Administrador</span>
                            </div>
                        </div>

                        {{-- Formulario --}}
                        <div class="col-lg-6 p-4 p-md-5 bg-white">
                            <h2 class="h3 mb-1">Iniciar sesión</h2>
                            <p class="text-gris mb-4">Usa tu correo y contraseña.</p>

                            @if (session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="nombre@tecsup.edu.pe" required autofocus>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                                        <input type="password" id="password" name="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="••••••••" required>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check mb-4 small">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Recordarme</label>
                                </div>

                                <button type="submit" class="btn btn-tl btn-lg w-100 mb-3">Ingresar</button>

                                <p class="text-center small text-gris mb-0">
                                    ¿No tienes cuenta?
                                    <a href="{{ route('register') }}" class="fw-semibold">Regístrate</a>
                                </p>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>