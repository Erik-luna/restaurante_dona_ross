@extends('layouts.app')

@section('title', 'Acceso Personal y Administración')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 72vh;">
    <div class="card-ross border-0 shadow-lg p-4 p-md-5" style="width: 100%; max-width: 440px; border-top: 5px solid var(--ross-primary) !important;">
        <div class="text-center mb-4">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; background: var(--ross-primary); color: var(--ross-gold);">
                <i class="bi bi-shield-lock-fill fs-2"></i>
            </div>
            <h3 class="fw-bold font-serif mb-1" style="color: var(--ross-primary);">Acceso al Panel</h3>
            <span class="badge badge-ross-gold text-dark px-3 py-1">ADMINISTRACIÓN & PERSONAL</span>
        </div>

        <form action="{{ route('login.admin.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Correo Corporativo</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                        <i class="bi bi-person-badge text-muted"></i>
                    </span>
                    <input type="email" class="form-control border-start-0 ps-0" name="email" value="{{ old('email') }}" placeholder="admin@donaross.com" required autofocus style="border-radius: 0 12px 12px 0;">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                        <i class="bi bi-key text-muted"></i>
                    </span>
                    <input type="password" class="form-control border-start-0 ps-0" name="password" placeholder="••••••••" required style="border-radius: 0 12px 12px 0;">
                </div>
            </div>

            <button type="submit" class="btn btn-ross-secondary btn-lg w-100 py-3 mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Ingresar al Panel
            </button>
        </form>

        <div class="text-center pt-3 border-top">
            <a href="{{ route('login.cliente') }}" class="text-danger small text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Volver a portal de clientes
            </a>
        </div>
    </div>
</div>
@endsection

