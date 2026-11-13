<x-layout>
    <div class="container py-5" style="max-width: 720px">
        <h1 class="h3 mb-1">Mi perfil</h1>
        <p class="text-gris mb-4">Actualiza tus datos y tu contraseña.</p>

        {{-- ===== Formulario 1: datos personales ===== --}}
        <div class="tarjeta p-4 mb-4">
            <h2 class="h5 mb-3"><i class="bi bi-person-circle me-2"></i>Mis datos</h2>

            @if (session('status') === 'profile-information-updated')
                <div class="alert alert-success">Tus datos se actualizaron correctamente.</div>
            @endif

            <form method="POST" action="{{ route('user-profile-information.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre completo</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror">
                    @error('name', 'updateProfileInformation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', auth()->user()->email) }}"
                           class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror">
                    @error('email', 'updateProfileInformation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-tl-amarillo">
                    <i class="bi bi-save me-1"></i> Guardar datos
                </button>
            </form>
        </div>

        {{-- ===== Formulario 2: contraseña ===== --}}
        <div class="tarjeta p-4">
            <h2 class="h5 mb-3"><i class="bi bi-lock me-2"></i>Cambiar contraseña</h2>

            @if (session('status') === 'password-updated')
                <div class="alert alert-success">Tu contraseña se cambió correctamente.</div>
            @endif

            <form method="POST" action="{{ route('user-password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Contraseña actual</label>
                    <input type="password" id="current_password" name="current_password"
                           class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nueva contraseña</label>
                    <input type="password" id="password" name="password"
                           class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Repetir nueva contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-tl-amarillo">
                    <i class="bi bi-key me-1"></i> Cambiar contraseña
                </button>
            </form>
        </div>
    </div>
</x-layout>