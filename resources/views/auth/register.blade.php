@extends('layouts.app')

@section('title', 'Crear Cuenta')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 72vh;">
    <div class="card-ross border-0 shadow-lg p-4 p-md-5" style="width: 100%; max-width: 540px; border-top: 5px solid var(--ross-orange) !important;">
        <div class="text-center mb-4">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="brand-logo-img mb-2" style="width: 65px; height: 65px;">
            <h3 class="fw-bold font-serif mb-1" style="color: var(--ross-primary);">Crear Nueva Cuenta</h3>
            <p class="text-muted small mb-0">Regístrate para pedir tus platillos favoritos y acceder a descuentos exclusivos</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-12">
                    <label class="form-label">Nombre Completo *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                            <i class="bi bi-person text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" name="name" value="{{ old('name') }}" placeholder="Ej: Juan Pérez" required autofocus style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Correo Electrónico *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                            <i class="bi bi-envelope-at text-muted"></i>
                        </span>
                        <input type="email" class="form-control border-start-0 ps-0" name="email" value="{{ old('email') }}" placeholder="tu@correo.com" required style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Teléfono / WhatsApp</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                            <i class="bi bi-telephone text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 70000000" style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Dirección de Entrega</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                            <i class="bi bi-geo-alt text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" name="direccion" value="{{ old('direccion') }}" placeholder="Ej: Calle 5 #12" style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Contraseña *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                            <i class="bi bi-lock text-muted"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 ps-0" name="password" placeholder="••••••••" required style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Confirmar Contraseña *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                            <i class="bi bi-check-circle text-muted"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 ps-0" name="password_confirmation" placeholder="••••••••" required style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-ross-primary btn-lg w-100 py-3 mb-3">
                <i class="bi bi-person-plus-fill me-1"></i> Completar Registro
            </button>
        </form>

        <div class="text-center pt-3 border-top">
            <p class="text-muted small mb-0">
                ¿Ya tienes una cuenta registrada? <a href="{{ route('login.cliente') }}" class="text-danger fw-bold text-decoration-none">Inicia sesión aquí</a>
            </p>
        </div>
    </div>
</div>
@endsection

