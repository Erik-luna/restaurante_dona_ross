@extends('layouts.admin')
@section('panel-title', 'Personal')
@section('sidebar')@include('partials.sidebar-personal')@endsection
@section('title', 'Panel del Personal')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Panel de Atención & Ventas</h2>
        <p class="text-muted small mb-0">Gestión de órdenes en salón, ventas en mostrador y registro de clientes.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('personal.ventas.create') }}" class="btn btn-ross-primary btn-sm">
            <i class="bi bi-cart-plus-fill me-1"></i> Registrar Venta
        </a>
        <a href="{{ route('personal.clientes.create') }}" class="btn btn-ross-secondary btn-sm">
            <i class="bi bi-person-plus-fill me-1"></i> Nuevo Cliente
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card-stat d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Ventas de Hoy</span>
                <h3 class="fw-bold mb-0" style="color: var(--ross-primary);">Bs. {{ number_format($stats['ventas_hoy'], 2) }}</h3>
                <small class="text-success fw-semibold"><i class="bi bi-graph-up-arrow me-1"></i> En caja hoy</small>
            </div>
            <div class="card-stat-icon" style="background: var(--ross-orange-light); color: var(--ross-orange);">
                <i class="bi bi-cash-coin"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-stat d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Pedidos Atendidos</span>
                <h3 class="fw-bold mb-0" style="color: var(--ross-primary);">{{ $stats['pedidos_hoy'] }}</h3>
                <small class="text-muted">Órdenes procesadas hoy</small>
            </div>
            <div class="card-stat-icon" style="background: var(--ross-gold-light); color: #B45309;">
                <i class="bi bi-check2-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-stat d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Clientes Registrados</span>
                <h3 class="fw-bold mb-0" style="color: var(--ross-primary);">{{ $stats['clientes'] }}</h3>
                <small class="text-muted">Total clientes en sistema</small>
            </div>
            <div class="card-stat-icon" style="background: #EFF6FF; color: #3B82F6;">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>
</div>

<div class="table-card p-4">
    <h5 class="fw-bold mb-3 font-serif" style="color: var(--ross-primary);">
        <i class="bi bi-lightning-charge-fill text-warning me-2"></i> Acciones Rápidas
    </h5>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="p-3 rounded-3 border bg-light d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="fw-bold mb-1">Venta en Mostrador / Mesa</h6>
                    <p class="text-muted small mb-0">Registrar un nuevo pedido local o para llevar.</p>
                </div>
                <a href="{{ route('personal.ventas.create') }}" class="btn btn-ross-primary btn-sm px-3">
                    <i class="bi bi-plus-lg"></i> Iniciar
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 rounded-3 border bg-light d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="fw-bold mb-1">Registrar Nuevo Cliente</h6>
                    <p class="text-muted small mb-0">Dar de alta a un cliente con sus datos de contacto.</p>
                </div>
                <a href="{{ route('personal.clientes.create') }}" class="btn btn-ross-secondary btn-sm px-3">
                    <i class="bi bi-person-plus"></i> Registrar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

