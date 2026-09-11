@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 72vh;">
    <div class="card-ross border-0 shadow-lg p-4 p-md-5" style="width: 100%; max-width: 440px; border-top: 5px solid var(--ross-orange) !important;">
        <div class="text-center mb-4">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="brand-logo-img mb-2" style="width: 65px; height: 65px;">
            <h3 class="fw-bold font-serif mb-1" style="color: var(--ross-primary);">Acceso Clientes</h3>
            <p class="text-muted small mb-0">Ingresa tus credenciales para ordenar y gestionar tus pedidos</p>
        </div>

        <form action="{{ route('login.cliente.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                        <i class="bi bi-envelope-at text-muted"></i>
                    </span>
                    <input type="email" class="form-control border-start-0 ps-0" name="email" value="{{ old('email') }}" placeholder="tu@correo.com" required autofocus style="border-radius: 0 12px 12px 0;">
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0">Contraseña</label>
                    <a href="{{ route('password.formulario') }}" class="text-danger small text-decoration-none">¿Olvidaste tu contraseña?</a>
                </div>
                <div class="input-group mt-1">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                        <i class="bi bi-lock text-muted"></i>
                    </span>
                    <input type="password" class="form-control border-start-0 ps-0" name="password" placeholder="••••••••" required style="border-radius: 0 12px 12px 0;">
                </div>
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label text-muted small" for="remember">Recordar mi sesión en este equipo</label>
            </div>

            <button type="submit" class="btn btn-ross-primary btn-lg w-100 py-3 mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
            </button>
        </form>

        <div class="text-center pt-3 border-top">
            <p class="text-muted small mb-2">
                ¿No tienes una cuenta? <a href="{{ route('register') }}" class="text-danger fw-bold text-decoration-none">Regístrate aquí</a>
            </p>
            <p class="mb-0">
                <a href="{{ route('login.admin') }}" class="text-muted small text-decoration-none">
                    <i class="bi bi-shield-lock me-1"></i> Acceso Personal / Admin
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

