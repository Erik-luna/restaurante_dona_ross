@extends('layouts.app')

@section('title', 'Mi Carrito de Compras')

@section('content')
<div class="container pb-5">
    <div class="section-header text-center mb-4">
        <span class="section-subtitle">Tu Selección</span>
        <h1 class="section-title">Carrito de Compras</h1>
        <div class="section-divider"></div>
    </div>

    @if(count($items))
    <div class="row g-4">
        <!-- Products Column -->
        <div class="col-lg-8">
            <div class="card-ross p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                    <h5 class="fw-bold mb-0 font-serif" style="color: var(--ross-primary);">
                        <i class="bi bi-basket3-fill text-danger me-2"></i> Platillos Seleccionados ({{ count($items) }})
                    </h5>
                    <a href="{{ route('catalogo') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 20px;">
                        <i class="bi bi-plus-lg"></i> Agregar más platos
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Platillo</th>
                                <th class="border-0">Precio</th>
                                <th class="border-0 text-center" style="width: 140px;">Cantidad</th>
                                <th class="border-0 text-end">Subtotal</th>
                                <th class="border-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $item['producto']->imagen ? asset('storage/'.$item['producto']->imagen) : asset('img/platos/plato' . (($loop->index % 5) + 1) . '.jpeg') }}" 
                                             class="rounded-3 shadow-sm" 
                                             alt="{{ $item['producto']->nombre }}" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $item['producto']->nombre }}</h6>
                                            <small class="text-muted">{{ $item['producto']->categoria->nombre ?? 'Especialidad' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-semibold text-muted">
                                    Bs. {{ number_format($item['producto']->precio, 2) }}
                                </td>
                                <td>
                                    <form action="{{ route('cliente.carrito.update', $item['producto']) }}" method="POST" class="d-flex align-items-center justify-content-center gap-1">
                                        @csrf @method('PUT')
                                        <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" max="{{ $item['producto']->stock }}" class="form-control form-control-sm text-center fw-bold" style="width:65px; border-radius: 8px;">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Actualizar">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end fw-bold fs-6" style="color: var(--ross-primary-dark);">
                                    Bs. {{ number_format($item['subtotal'], 2) }}
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('cliente.carrito.remove', $item['producto']) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle" title="Eliminar plato">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Checkout Column -->
        <div class="col-lg-4">
            <div class="card-ross p-4 position-sticky" style="top: 100px; border-top: 5px solid var(--ross-orange) !important;">
                <h4 class="fw-bold mb-3 font-serif" style="color: var(--ross-primary);">
                    Resumen de Pedido
                </h4>

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Subtotal estimado:</span>
                    <span class="fw-semibold">Bs. {{ number_format($total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Envío Delivery:</span>
                    <span class="text-success fw-bold">GRATIS</span>
                </div>
                <div class="d-flex justify-content-between py-3 mb-4">
                    <span class="fs-5 fw-bold font-serif">Total a Pagar:</span>
                    <span class="fs-4 fw-bold" style="color: var(--ross-primary-dark);">
                        Bs. {{ number_format($total, 2) }}
                    </span>
                </div>

                <h5 class="fw-bold mb-3 font-serif" style="color: var(--ross-primary);">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> Datos de Entrega
                </h5>

                <form action="{{ route('cliente.checkout') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Dirección de entrega *</label>
                        <input type="text" name="direccion_entrega" class="form-control" value="{{ auth()->user()->direccion }}" placeholder="Ej: Av. Principal #456" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teléfono de contacto *</label>
                        <input type="text" name="telefono_contacto" class="form-control" value="{{ auth()->user()->telefono }}" placeholder="Ej: 70000003" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Notas para la cocina o entrega</label>
                        <textarea name="notas" class="form-control" rows="2" placeholder="Ej: Sin cebolla, salsa extra, timbre al llegar..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-ross-primary btn-lg w-100 py-3">
                        <i class="bi bi-bag-check-fill fs-5"></i> Confirmar y Pedir Ahora
                    </button>
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <div class="card-ross p-5 mx-auto" style="max-width: 480px;">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; background: var(--ross-orange-light); color: var(--ross-orange);">
                <i class="bi bi-cart-x fs-1"></i>
            </div>
            <h3 class="fw-bold font-serif mb-2" style="color: var(--ross-primary);">Tu carrito está vacío</h3>
            <p class="text-muted small mb-4">Aún no has agregado deliciosos platos a tu pedido. ¡Explora nuestra carta y date un gusto!</p>
            <a href="{{ route('catalogo') }}" class="btn btn-ross-primary btn-lg px-4">
                <i class="bi bi-egg-fried me-1"></i> Ver Catálogo de Platos
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

