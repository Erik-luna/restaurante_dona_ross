@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Detalle del Cliente')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Detalle del Cliente</h2>
        <p class="text-muted small mb-0">Información registrada de la cuenta de cliente.</p>
    </div>
    <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Volver a la lista
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-ross p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-4 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white fs-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--ross-primary) 0%, var(--ross-orange) 100%);">
                        {{ strtoupper(substr($cliente->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 font-serif text-dark">{{ $cliente->name }}</h4>
                        <span class="badge badge-ross-gold text-dark px-3 py-1 fw-bold">Cuenta de Cliente</span>
                    </div>
                </div>
                <span class="badge bg-secondary-subtle text-secondary border px-3 py-2">
                    <i class="bi bi-eye me-1"></i> Modo solo lectura
                </span>
            </div>

            <table class="table table-borderless mb-4">
                <tbody>
                    <tr>
                        <th style="width: 30%;" class="text-muted small text-uppercase"># ID</th>
                        <td class="fw-bold text-danger">#{{ $cliente->id }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted small text-uppercase">Correo Electrónico</th>
                        <td class="fw-semibold">{{ $cliente->email }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted small text-uppercase">Teléfono</th>
                        <td>
                            @if($cliente->telefono)
                                <a href="https://wa.me/591{{ $cliente->telefono }}" target="_blank" class="text-success text-decoration-none fw-semibold">
                                    <i class="bi bi-whatsapp me-1"></i> {{ $cliente->telefono }}
                                </a>
                            @else
                                <span class="text-muted">No especificado</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted small text-uppercase">Dirección de Entrega</th>
                        <td>{{ $cliente->direccion ?? 'No especificada' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted small text-uppercase">Estado de Cuenta</th>
                        <td>
                            <span class="badge rounded-pill px-3 py-1 {{ $cliente->activo ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border' }}">
                                {{ $cliente->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted small text-uppercase">Fecha de Registro</th>
                        <td>{{ $cliente->created_at?->format('d/m/Y \a \l\a\s H:i') ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="p-3 bg-light rounded-3 border text-muted small">
                <i class="bi bi-info-circle text-primary me-1"></i>
                Como administrador puedes consultar los datos del cliente para soporte o gestión de órdenes. La edición directa está reservada para el panel de atención.
            </div>
        </div>
    </div>
</div>
@endsection

