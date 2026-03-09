@extends('layouts.app')

@section('title', 'Panel de Cliente')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>¡Bienvenido!</h1>
        <p>Has ingresado exitosamente al portal de clientes</p>
    </div>

    <div style="text-align: center; padding: 20px 0;">
        <div style="font-size: 60px; margin-bottom: 15px;">👤</div>
        <h2 style="font-size: 20px; color: #1a1a2e; margin-bottom: 8px;">
            {{ Auth::user()->name }}
        </h2>
        <p style="font-size: 14px; color: #666; margin-bottom: 30px;">
            {{ Auth::user()->email }}
        </p>

        <div style="
            background-color: #f0f2f5;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 30px;
            font-size: 14px;
            color: #444;
        ">
            Estás en el área exclusiva para clientes de <strong>Novaq</strong>.
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn" style="background-color: #e53e3e;">
                Cerrar sesión
            </button>
        </form>
    </div>
</div>
@endsection
