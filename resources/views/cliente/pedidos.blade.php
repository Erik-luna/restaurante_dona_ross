@extends('layouts.app')

@section('title', 'Mis Pedidos')

@section('content')
<div class="container pb-5">
    <div class="section-header text-center mb-4">
        <span class="section-subtitle">Historial de Compras</span>
        <h1 class="section-title">Mis Pedidos</h1>
        <div class="section-divider"></div>
    </div>

    @if($pedidos->count())
    <div class="row g-4">
        @foreach($pedidos as $pedido)
        <div class="col-lg-6">
            <div class="card-ross h-100 p-4 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                        <div>
                            <span class="fs-5 fw-bold font-serif" style="color: var(--ross-primary);">Pedido #{{ $pedido->id }}</span>
                            <span class="text-muted small d-block">{{ $pedido->created_at->format('d/m/Y - H:i') }} hrs</span>
                        </div>
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
                        <span class="badge rounded-pill px-3 py-2 fw-semibold {{ $statusBadges[$pedido->estado] ?? 'bg-secondary' }}">
                            {{ ucfirst($pedido->estado) }}
                        </span>
                    </div>

                    <h6 class="fw-bold mb-2 text-muted small text-uppercase">Detalle del Pedido:</h6>
                    <div class="bg-light p-3 rounded-3 mb-3">
                        <ul class="list-unstyled mb-0">
                            @foreach($pedido->items as $item)
                            <li class="d-flex justify-content-between py-1 border-bottom border-light-subtle small">
                                <span>
                                    <strong>{{ $item->cantidad }}x</strong> {{ $item->producto->nombre }}
                                </span>
                                <span class="fw-semibold text-muted">
                                    Bs. {{ number_format($item->subtotal, 2) }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    @if($pedido->direccion_entrega)
                        <p class="small text-muted mb-1">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> <strong>Entrega en:</strong> {{ $pedido->direccion_entrega }}
                        </p>
                    @endif
                    @if($pedido->notas)
                        <p class="small text-muted mb-0">
                            <i class="bi bi-chat-left-dots text-warning me-1"></i> <strong>Notas:</strong> {{ $pedido->notas }}
                        </p>
                    @endif
                </div>

                <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle mt-3">
                    <span class="text-muted small">Monto Total</span>
                    <span class="fs-4 fw-bold" style="color: var(--ross-primary-dark);">
                        Bs. {{ number_format($pedido->total, 2) }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $pedidos->links('pagination::bootstrap-5') }}
    </div>
    @else
    <div class="text-center py-5">
        <div class="card-ross p-5 mx-auto" style="max-width: 480px;">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; background: #E8F8F0; color: #10B981;">
                <i class="bi bi-bag-check fs-1"></i>
            </div>
            <h3 class="fw-bold font-serif mb-2" style="color: var(--ross-primary);">Aún no tienes pedidos</h3>
            <p class="text-muted small mb-4">Cuando realices una compra de nuestros platillos favoritos, podrás rastrear y ver el estado de todos tus pedidos aquí.</p>
            <a href="{{ route('catalogo') }}" class="btn btn-ross-primary btn-lg px-4">
                <i class="bi bi-egg-fried me-1"></i> Explorar Catálogo
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

