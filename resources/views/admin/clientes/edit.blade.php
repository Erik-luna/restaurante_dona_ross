@extends('layouts.admin')
@section('panel-title', auth()->user()->isAdmin() ? 'Administración' : 'Personal')
@section('sidebar')@include(auth()->user()->isAdmin() ? 'partials.sidebar-admin' : 'partials.sidebar-personal')@endsection
@section('title', 'Editar Cliente')

@section('content')
@php $prefix = auth()->user()->isAdmin() ? 'admin' : 'personal'; @endphp

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Editar: {{ $cliente->name }}</h2>
        <p class="text-muted small mb-0">Actualiza los datos de contacto y estado del cliente.</p>
    </div>
    <a href="{{ route($prefix.'.clientes.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Volver a la lista
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-ross p-4 p-md-5">
            <form action="{{ route($prefix.'.clientes.update', $cliente) }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre Completo *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $cliente->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Correo Electrónico *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $cliente->email) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nueva Contraseña (Opcional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para mantener actual">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Teléfono / WhatsApp</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Dirección de Entrega</label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion) }}">
                    </div>

                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="form-check form-switch mb-0">
                                <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" {{ old('activo', $cliente->activo) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="activo">Cliente Activo</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-4 border-top mt-4">
                    <a href="{{ route($prefix.'.clientes.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
                    <button type="submit" class="btn btn-ross-primary px-4">
                        <i class="bi bi-check-lg me-1"></i> Actualizar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

