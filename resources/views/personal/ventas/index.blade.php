@extends('layouts.admin')
@section('panel-title', auth()->user()->isAdmin() ? 'Administración' : 'Personal')
@section('sidebar')@include(auth()->user()->isAdmin() ? 'partials.sidebar-admin' : 'partials.sidebar-personal')@endsection
@section('title', 'Ventas Locales')

@section('content')
@php $prefix = auth()->user()->isAdmin() ? 'admin' : 'personal'; @endphp

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Ventas Locales & Mostrador</h2>
        <p class="text-muted small mb-0">Registro y consulta de ventas en salón, caja y para llevar.</p>
    </div>
    <a href="{{ route($prefix.'.ventas.create') }}" class="btn btn-ross-primary">
        <i class="bi bi-cart-plus-fill me-1"></i> Registrar Nueva Venta
    </a>
</div>

<div class="table-card p-0 mb-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;"># Ticket</th>
                    <th>Cliente</th>
                    <th>Atendido por</th>
                    <th>Total Cobrado</th>
                    <th>Fecha / Hora</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $v)
                <tr>
                    <td class="fw-bold text-danger">#{{ $v->id }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $v->user->name ?? 'Cliente General' }}</div>
                        <small class="text-muted">{{ $v->user->email ?? '-' }}</small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-person me-1"></i> {{ $v->atendidoPor->name ?? 'Personal' }}
                        </span>
                    </td>
                    <td class="fw-bold fs-6" style="color: var(--ross-primary-dark);">
                        Bs. {{ number_format($v->total, 2) }}
                    </td>
                    <td>
                        <span class="small text-dark fw-semibold">{{ $v->created_at->format('d/m/Y') }}</span>
                        <small class="d-block text-muted">{{ $v->created_at->format('H:i') }} hrs</small>
                    </td>
                    <td class="text-end">
                        <a href="{{ route($prefix.'.ventas.show', $v) }}" class="btn btn-sm btn-ross-primary rounded-pill px-3">
                            <i class="bi bi-receipt"></i> Ver Ticket
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">No hay ventas locales registradas aún.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $ventas->links('pagination::bootstrap-5') }}
</div>
@endsection

