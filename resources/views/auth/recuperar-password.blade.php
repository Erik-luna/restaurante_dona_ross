@extends('layouts.app')

@section('title', 'Recuperar Contraseña')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 72vh;">
    <div class="card-ross border-0 shadow-lg p-4 p-md-5" style="width: 100%; max-width: 460px; border-top: 5px solid var(--ross-orange) !important;">
        <div class="text-center mb-4">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; background: var(--ross-orange-light); color: var(--ross-orange);">
                <i class="bi bi-key-fill fs-2"></i>
            </div>
            <h3 class="fw-bold font-serif mb-1" style="color: var(--ross-primary);">Recuperar Contraseña</h3>
            <p class="text-muted small mb-0">Restablece el acceso a tu cuenta de Doña Ross</p>
        </div>

        @if(session('recuperacion_email'))
            {{-- Step 2: Verification code and new password --}}
            <div class="p-3 mb-4 rounded-4 text-center" style="background: var(--ross-gold-light); border: 1.5px dashed #D97706;">
                <span class="text-muted small d-block mb-1">Tu código temporal de verificación es:</span>
                <div class="fs-2 fw-bold font-monospace text-dark" style="letter-spacing: 8px;">
                    {{ session('recuperacion_codigo') }}
                </div>
                <small class="text-muted">Introduce este código junto con tu nueva contraseña.</small>
            </div>

            <form action="{{ route('password.cambiar') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ session('recuperacion_email') }}">
                
                <div class="mb-3">
                    <label class="form-label">Código de Verificación (6 dígitos)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                            <i class="bi bi-shield-check text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 text-center font-monospace fs-5 fw-bold {{ $errors->has('codigo') ? 'is-invalid' : '' }}" name="codigo" maxlength="6" placeholder="000000" required autofocus style="border-radius: 0 12px 12px 0; letter-spacing: 4px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nueva Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                            <i class="bi bi-lock text-muted"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 ps-0" name="password" minlength="8" placeholder="Mínimo 8 caracteres" required style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirmar Nueva Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                            <i class="bi bi-check2-circle text-muted"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 ps-0" name="password_confirmation" placeholder="Repite la contraseña" required style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>

                <button type="submit" class="btn btn-ross-primary btn-lg w-100 py-3 mb-3">
                    <i class="bi bi-check-lg me-1"></i> Restablecer Contraseña
                </button>
            </form>

            <div class="text-center pt-2 border-top">
                <a href="{{ route('password.limpiar') }}" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-clockwise me-1"></i> Usar otro correo electrónico
                </a>
            </div>
        @else
            {{-- Step 1: Request email --}}
            <form action="{{ route('password.codigo') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Correo Electrónico Registrado</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                            <i class="bi bi-envelope-at text-muted"></i>
                        </span>
                        <input type="email" class="form-control border-start-0 ps-0" name="email" value="{{ old('email') }}" placeholder="tu@correo.com" required autofocus style="border-radius: 0 12px 12px 0;">
                    </div>
                    <small class="text-muted mt-1 d-block">Generaremos un código de verificación para que puedas cambiar tu contraseña.</small>
                </div>

                <button type="submit" class="btn btn-ross-primary btn-lg w-100 py-3 mb-3">
                    <i class="bi bi-send-fill me-1"></i> Generar Código de Recuperación
                </button>
            </form>

            <div class="text-center pt-2 border-top">
                <a href="{{ route('login.cliente') }}" class="text-danger small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Volver a Iniciar Sesión
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

