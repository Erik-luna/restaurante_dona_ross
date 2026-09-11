@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Pedidos Online')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Gestión de Pedidos Online</h2>
        <p class="text-muted small mb-0">Monitorea y actualiza el estado de las órdenes realizadas por los clientes.</p>
    </div>
</div>

<div class="table-card p-0 mb-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;"># ID</th>
                    <th>Cliente</th>
                    <th>Contacto & Dirección</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha / Hora</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidos as $p)
                <tr>
                    <td class="fw-bold text-danger">#{{ $p->id }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $p->user->name ?? 'Cliente Web' }}</div>
                        <small class="text-muted">{{ $p->user->email ?? '-' }}</small>
                    </td>
                    <td>
                        <div class="small fw-semibold">{{ $p->telefono_contacto ?: 'Sin teléfono' }}</div>
                        <small class="text-muted d-block text-truncate" style="max-width: 220px;">{{ $p->direccion_entrega ?: 'Sin dirección' }}</small>
                    </td>
                    <td class="fw-bold fs-6" style="color: var(--ross-primary-dark);">
                        Bs. {{ number_format($p->total, 2) }}
                    </td>
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
                    <td>
                        <span class="small text-muted">{{ $p->created_at->format('d/m/Y') }}</span>
                        <small class="d-block text-muted">{{ $p->created_at->format('H:i') }} hrs</small>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.pedidos.show', $p) }}" class="btn btn-sm btn-ross-primary rounded-pill px-3">
                            <i class="bi bi-eye-fill me-1"></i> Atender
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">No hay pedidos online registrados hasta el momento.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $pedidos->links('pagination::bootstrap-5') }}
</div>
@endsection

