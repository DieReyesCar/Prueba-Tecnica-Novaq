@extends('layouts.app')

@section('title', 'Nueva Contraseña')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Nueva Contraseña</h1>
        <p>Ingresa tu nueva contraseña para recuperar el acceso</p>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        {{-- Token oculto necesario para validar la solicitud --}}
        <input type="hidden" name="token" value="{{ $token }}">

        <input type="hidden" name="email" value="{{ request()->email }}">

        <div class="form-group">
            <label for="password">Nueva contraseña</label>
            <div class="password-wrapper">
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="******"
                    class="{{ $errors->has('password') ? 'error' : '' }}">
                <span class="toggle-password" onclick="togglePassword('password')">👁</span>
            </div>
            @error('password')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar contraseña</label>
            <div class="password-wrapper">
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="******">
                <span class="toggle-password" onclick="togglePassword('password_confirmation')">👁</span>
            </div>
        </div>

        <button type="submit" class="btn">Actualizar contraseña</button>
    </form>

    <div class="links">
        <a href="{{ route('login') }}">← Volver al login</a>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const input = document.getElementById(fieldId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection