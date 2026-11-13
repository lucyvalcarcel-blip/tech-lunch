<x-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="tarjeta login-caja">
                    <div class="row g-0">

                        {{-- Panel de color --}}
                        <div class="col-lg-6 satin-azul login-panel p-4 p-md-5 d-flex flex-column justify-content-center">
                            <h1 class="h2 mb-3">¡Bienvenido a TECH-LUNCH!</h1>
                            <p class="mb-4" style="opacity:.92">
                                Crea tu cuenta para pedir tu comida sin hacer cola y recogerla en el cafetín.
                            </p>
                            <div class="d-flex gap-4 small" style="opacity:.9">
                                <span><i class="bi bi-lightning-charge me-1"></i> Rápido</span>
                                <span><i class="bi bi-phone me-1"></i> Yape y Plin</span>
                                <span><i class="bi bi-cup-hot me-1"></i> Sin colas</span>
                            </div>
                        </div>

                        {{-- Formulario --}}
                        <div class="col-lg-6 p-4 p-md-5 bg-white">
                            <h2 class="h3 mb-1">Crear cuenta</h2>
                            <p class="text-gris mb-4">Completa tus datos para registrarte.</p>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre completo</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Ej.: Ana Torres" required autofocus>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="nombre@tecsup.edu.pe" required>
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
                                               placeholder="Mínimo 8 caracteres" required>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Repetir contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                               class="form-control" placeholder="Vuelve a escribirla" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-tl btn-lg w-100 mb-3">Registrarme</button>

                                <p class="text-center small text-gris mb-0">
                                    ¿Ya tienes cuenta?
                                    <a href="{{ route('login') }}" class="fw-semibold">Inicia sesión</a>
                                </p>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>