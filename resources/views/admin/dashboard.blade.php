@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Dashboard General')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Panel de Administración</h2>
        <p class="text-muted small mb-0">Resumen operativo general, ventas y pedidos del restaurante.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.productos.create') }}" class="btn btn-ross-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Nuevo Producto
        </a>
        <a href="{{ route('admin.ventas.create') }}" class="btn btn-ross-secondary btn-sm">
            <i class="bi bi-receipt"></i> Registrar Venta
        </a>
    </div>
</div>

<!-- Stat Cards Grid -->
<div class="row g-3 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card-stat d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Ventas de Hoy</span>
                <h3 class="fw-bold mb-0" style="color: var(--ross-primary);">Bs. {{ number_format($stats['ventas_hoy'], 2) }}</h3>
                <small class="text-success fw-semibold"><i class="bi bi-graph-up-arrow me-1"></i> Facturación del día</small>
            </div>
            <div class="card-stat-icon" style="background: var(--ross-orange-light); color: var(--ross-orange);">
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card-stat d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Pedidos de Hoy</span>
                <h3 class="fw-bold mb-0" style="color: var(--ross-primary);">{{ $stats['pedidos_hoy'] }}</h3>
                <small class="text-muted">Pedidos recibidos hoy</small>
            </div>
            <div class="card-stat-icon" style="background: var(--ross-gold-light); color: #B45309;">
                <i class="bi bi-cart-check-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card-stat d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Pedidos Pendientes</span>
                <h3 class="fw-bold mb-0 text-danger">{{ $stats['pedidos_pendientes'] }}</h3>
                <small class="text-danger fw-semibold"><i class="bi bi-exclamation-circle me-1"></i> Requieren atención</small>
            </div>
            <div class="card-stat-icon" style="background: #FEE2E2; color: #DC2626;">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card-stat d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Productos</span>
                <h3 class="fw-bold mb-0">{{ $stats['productos'] }}</h3>
                <small class="text-muted">Platillos en menú</small>
            </div>
            <div class="card-stat-icon" style="background: #E8F8F0; color: #10B981;">
                <i class="bi bi-egg-fried"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card-stat d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Clientes Registrados</span>
                <h3 class="fw-bold mb-0">{{ $stats['clientes'] }}</h3>
                <small class="text-muted">Usuarios en la base de datos</small>
            </div>
            <div class="card-stat-icon" style="background: #EFF6FF; color: #3B82F6;">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card-stat d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Personal Activo</span>
                <h3 class="fw-bold mb-0">{{ $stats['personal'] }}</h3>
                <small class="text-muted">Personal de atención y cocina</small>
            </div>
            <div class="card-stat-icon" style="background: #FAF5FF; color: #8B5CF6;">
                <i class="bi bi-person-badge-fill"></i>
            </div>
        </div>
    </div>
</div>

<!-- orden de los card y en las tablas que tienen que hacer  -->    
<div class="table-card p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4 class="fw-bold mb-0 font-serif" style="color: var(--ross-primary);">
            <i class="bi bi-receipt text-danger me-2"></i> Pedidos Recientes
        </h4>
        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            Ver todos los pedidos &rarr;
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    
                    <th># Pedido</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidosRecientes as $p)
                <tr>
                    <td class="fw-bold text-danger">#{{ $p->id }}</td>
                    <td>
                        <div class="fw-semibold">{{ $p->user->name ?? 'Cliente General' }}</div>
                        <small class="text-muted">{{ $p->user->email ?? '-' }}</small>
                    </td>
                    <td class="fw-bold">Bs. {{ number_format($p->total, 2) }}</td>
                    <td>
                        @php
                            $statusBadges = [
                                'pendiente' => 'bg-warning-subtle text-warning-emphasis border border-warning',
                                'confirmado' => 'bg-info-subtle text-info-emphasis border border-info',
                                'preparando' => 'bg-primary-subtle text-primary border border-primary',
                                'enviado' => 'bg-purple-subtle text-primary border border-primary',
                                'entregado' => 'bg-success-subtle text-success border border-success',
                                'cancelado' => 'bg-danger-subtle text-danger border border-danger',
                            ];
                        @endphp
                        <span class="badge rounded-pill px-3 py-1 {{ $statusBadges[$p->estado] ?? 'bg-secondary' }}">
                            {{ ucfirst($p->estado) }}
                        </span>
                    </td>
                    <td>{{ $p->created_at->format('d/m/Y - H:i') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.pedidos.show', $p) }}" class="btn btn-sm btn-ross-primary px-3">
                            <i class="bi bi-eye"></i> Detalle
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No hay pedidos recientes registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
