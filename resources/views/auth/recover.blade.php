@extends('layouts.app')

@section('title', 'Recuperar Contraseña')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Recuperar Contraseña</h1>
        <p>Ingresa tu correo y te enviaremos las instrucciones</p>
    </div>

    {{-- Si ya se generó el link, solo mostramos eso --}}
    @if(session('reset_url'))
        <div class="alert alert-success">
            Enlace de recuperación generado exitosamente.
        </div>

        <div class="alert alert-success" style="word-break: break-all;">
            <strong>🔗 Link de recuperación:</strong><br><br>
            <a href="{{ session('reset_url') }}" style="color: #276749;">
                {{ session('reset_url') }}
            </a>
            <br><br>
            <small>Este link es solo visible en entorno de pruebas.</small>
        </div>

        <div class="links">
            <a href="{{ route('login') }}">← Volver al login</a>
        </div>

    {{-- Si no hay link aún, mostramos el formulario --}}
    @else
        <form method="POST" action="{{ route('recover') }}">
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

            <button type="submit" class="btn">Enviar instrucciones</button>
        </form>

        <div class="links">
            <a href="{{ route('login') }}">← Volver al login</a>
        </div>
    @endif
</div>
@endsection