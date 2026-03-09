@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Portal Clientes</h1>
        <p>Ingresa tus credenciales para acceder</p>
    </div>

    {{-- Mensaje de éxito (viene del reset de contraseña) --}}
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Error general de credenciales --}}
    @if($errors->has('email') && !$errors->has('password'))
        <div class="alert alert-error">
            {{ $errors->first('email') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="cliente@empresa.com"
                class="{{ $errors->has('email') ? 'error' : '' }}"
                autofocus
            >
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="password-wrapper">
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    class="{{ $errors->has('password') ? 'error' : '' }}"
                >
                <span class="toggle-password" onclick="togglePassword()">👁</span>
            </div>
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn">Ingresar</button>
    </form>

    <div class="links">
        <a href="{{ route('recover') }}">¿Olvidaste tu contraseña?</a>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection