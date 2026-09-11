@extends('layouts.app')

@section('title', 'Mi Panel de Cliente')

@section('content')
<div class="container pb-5">
    <!-- Welcome Header Card -->
    <div class="card-ross p-4 p-md-5 mb-4 text-white shadow" style="background: linear-gradient(135deg, var(--ross-primary) 0%, #52090C 100%); border-left: 8px solid var(--ross-gold) !important;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-dark fw-bold fs-3" style="width: 64px; height: 64px; background: var(--ross-gold); border: 2px solid white;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <span class="badge badge-ross-gold text-dark px-3 py-1 mb-1">CLIENTE REGISTRADO</span>
                    <h2 class="fw-bold mb-0 font-serif text-white">¡Hola, {{ auth()->user()->name }}!</h2>
                    <p class="text-white-50 small mb-0">{{ auth()->user()->email }} • {{ auth()->user()->telefono ?: 'Sin teléfono registrado' }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('catalogo') }}" class="btn btn-ross-gold btn-sm px-3">
                    <i class="bi bi-egg-fried me-1"></i> Explorar Menú
                </a>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card-ross h-100 p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fw-semibold small text-uppercase">Carrito de Compras</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: var(--ross-orange-light); color: var(--ross-orange);">
                        <i class="bi bi-cart3 fs-4"></i>
                    </div>
                </div>
                <div class="mb-3">
                    <span class="display-5 fw-bold" style="color: var(--ross-primary);">{{ $carritoCount }}</span>
                    <span class="text-muted small"> ítems activos</span>
                </div>
                <a href="{{ route('cliente.carrito') }}" class="btn btn-ross-primary btn-sm w-100">
                    <i class="bi bi-cart-check me-1"></i> Ver mi Carrito
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-ross h-100 p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fw-semibold small text-uppercase">Mis Pedidos Realizados</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #E8F8F0; color: #10B981;">
                        <i class="bi bi-bag-check-fill fs-4"></i>
                    </div>
                </div>
                <div class="mb-3">
                    <span class="display-5 fw-bold" style="color: var(--ross-primary);">{{ auth()->user()->pedidos()->count() }}</span>
                    <span class="text-muted small"> pedidos históricos</span>
                </div>
                <a href="{{ route('cliente.pedidos') }}" class="btn btn-ross-outline btn-sm w-100">
                    <i class="bi bi-receipt me-1"></i> Historial Completo
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-ross h-100 p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fw-semibold small text-uppercase">Mi Perfil & Datos</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: var(--ross-gold-light); color: #B45309;">
                        <i class="bi bi-person-gear fs-4"></i>
                    </div>
                </div>
                <div class="mb-3">
                    <h6 class="fw-bold mb-1">{{ Str::limit(auth()->user()->direccion ?: 'Dirección no especificada', 30) }}</h6>
                    <span class="text-muted small">Dirección predeterminada de entrega</span>
                </div>
                <a href="{{ route('cliente.perfil') }}" class="btn btn-outline-secondary btn-sm w-100" style="border-radius: 30px;">
                    <i class="bi bi-pencil-square me-1"></i> Modificar Datos
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    @if($pedidos->count())
    <div class="card-ross p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="fw-bold mb-0 font-serif" style="color: var(--ross-primary);">
                <i class="bi bi-clock-history text-danger me-2"></i> Pedidos Recientes
            </h4>
            <a href="{{ route('cliente.pedidos') }}" class="text-danger small fw-bold text-decoration-none">Ver todos &rarr;</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0"># Pedido</th>
                        <th class="border-0">Fecha y Hora</th>
                        <th class="border-0">Total</th>
                        <th class="border-0">Estado</th>
                        <th class="border-0 text-end">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                    <tr>
                        <td class="fw-bold text-danger">#{{ $pedido->id }}</td>
                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                        <td class="fw-bold">Bs. {{ number_format($pedido->total, 2) }}</td>
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
                            <span class="badge rounded-pill px-3 py-2 {{ $statusBadges[$pedido->estado] ?? 'bg-secondary' }}">
                                {{ ucfirst($pedido->estado) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('cliente.pedidos') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

