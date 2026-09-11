@extends('layouts.app')

@section('title', 'Mi Perfil de Usuario')

@section('content')
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="section-header text-center mb-4">
                <span class="section-subtitle">Configuración</span>
                <h1 class="section-title">Mi Perfil</h1>
                <div class="section-divider"></div>
            </div>

            <div class="card-ross p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold fs-2 flex-shrink-0" style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--ross-primary) 0%, var(--ross-orange) 100%);">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">{{ $user->name }}</h4>
                        <span class="badge badge-ross-gold text-dark px-3 py-1 fw-bold">Cuenta de Cliente</span>
                    </div>
                </div>

                <form action="{{ route('cliente.perfil.update') }}" method="POST">
                    @csrf @method('PUT')

                    <h5 class="fw-bold mb-3 font-serif" style="color: var(--ross-primary);">
                        <i class="bi bi-person-lines-fill text-danger me-2"></i> Información Personal
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nombre Completo *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                                    <i class="bi bi-person text-muted"></i>
                                </span>
                                <input type="text" name="name" class="form-control border-start-0 ps-0" value="{{ old('name', $user->name) }}" required style="border-radius: 0 12px 12px 0;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email" class="form-control bg-light border-start-0 ps-0 text-muted" value="{{ $user->email }}" disabled style="border-radius: 0 12px 12px 0;" title="El correo no se puede modificar">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Teléfono de Contacto</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                                    <i class="bi bi-telephone text-muted"></i>
                                </span>
                                <input type="text" name="telefono" class="form-control border-start-0 ps-0" value="{{ old('telefono', $user->telefono) }}" placeholder="Ej: 70000003" style="border-radius: 0 12px 12px 0;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Dirección Principal de Entrega</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                                    <i class="bi bi-geo-alt text-muted"></i>
                                </span>
                                <input type="text" name="direccion" class="form-control border-start-0 ps-0" value="{{ old('direccion', $user->direccion) }}" placeholder="Ej: Av. Principal #456" style="border-radius: 0 12px 12px 0;">
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3 font-serif" style="color: var(--ross-primary);">
                        <i class="bi bi-shield-lock text-warning me-2"></i> Cambiar Contraseña (Opcional)
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nueva Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                                    <i class="bi bi-key text-muted"></i>
                                </span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Dejar en blanco para mantener actual" style="border-radius: 0 12px 12px 0;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Confirmar Nueva Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                                    <i class="bi bi-check-circle text-muted"></i>
                                </span>
                                <input type="password" name="password_confirmation" class="form-control border-start-0 ps-0" placeholder="Repite la nueva contraseña" style="border-radius: 0 12px 12px 0;">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-ross-primary px-4 py-2">
                            <i class="bi bi-check-lg me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

