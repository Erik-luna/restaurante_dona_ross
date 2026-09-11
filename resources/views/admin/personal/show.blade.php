@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Detalle del Personal')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Ficha de Personal</h2>
        <p class="text-muted small mb-0">Información registrada del colaborador del restaurante.</p>
    </div>
    <a href="{{ route('admin.personal.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Volver a la lista
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-ross p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-4 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-dark fs-3" style="width: 60px; height: 60px; background: var(--ross-gold);">
                        {{ strtoupper(substr($personal->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 font-serif text-dark">{{ $personal->name }}</h4>
                        <span class="badge badge-ross-primary px-3 py-1">Personal de Atención</span>
                    </div>
                </div>
                <span class="badge bg-secondary-subtle text-secondary border px-3 py-2">
                    <i class="bi bi-eye me-1"></i> Modo solo lectura
                </span>
            </div>

            <table class="table table-borderless mb-4">
                <tbody>
                    <tr>
                        <th style="width: 30%;" class="text-muted small text-uppercase"># ID Colaborador</th>
                        <td class="fw-bold text-danger">#{{ $personal->id }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted small text-uppercase">Correo Electrónico</th>
                        <td class="fw-semibold">{{ $personal->email }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted small text-uppercase">Teléfono de Contacto</th>
                        <td>{{ $personal->telefono ?: 'No especificado' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted small text-uppercase">Rol en Sistema</th>
                        <td><span class="badge bg-light text-dark border">Personal / Operador</span></td>
                    </tr>
                    <tr>
                        <th class="text-muted small text-uppercase">Estado Actual</th>
                        <td>
                            <span class="badge rounded-pill px-3 py-1 {{ $personal->activo ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border' }}">
                                {{ $personal->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted small text-uppercase">Fecha de Registro</th>
                        <td>{{ $personal->created_at?->format('d/m/Y \a \l\a\s H:i') ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

