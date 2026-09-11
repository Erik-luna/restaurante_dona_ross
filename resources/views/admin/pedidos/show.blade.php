@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Detalle de Pedido #'.$pedido->id)

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Pedido #{{ $pedido->id }}</h2>
        <p class="text-muted small mb-0">Registrado el {{ $pedido->created_at->format('d/m/Y \a \l\a\s H:i') }} hrs</p>
    </div>
    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Volver al listado
    </a>
</div>

<div class="row g-4">
    <!-- Order Items Column -->
    <div class="col-lg-8">
        <div class="card-ross p-4 mb-4">
            <h5 class="fw-bold mb-3 font-serif" style="color: var(--ross-primary);">
                <i class="bi bi-basket3 text-danger me-2"></i> Platillos Ordenados
            </h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Platillo</th>
                            <th class="border-0 text-center">Cantidad</th>
                            <th class="border-0 text-end">Precio Unit.</th>
                            <th class="border-0 text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedido->items as $item)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->producto->nombre }}</div>
                                <small class="text-muted">{{ $item->producto->categoria->nombre ?? 'Especialidad' }}</small>
                            </td>
                            <td class="text-center fw-bold">{{ $item->cantidad }}</td>
                            <td class="text-end text-muted">Bs. {{ number_format($item->precio_unitario, 2) }}</td>
                            <td class="text-end fw-bold" style="color: var(--ross-primary);">Bs. {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end border-0 pt-3 fs-5 font-serif">Total del Pedido:</th>
                            <th class="text-end border-0 pt-3 fs-4 fw-bold" style="color: var(--ross-primary-dark);">
                                Bs. {{ number_format($pedido->total, 2) }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Client & Status Column -->
    <div class="col-lg-4">
        <!-- Status Changer Card -->
        <div class="card-ross p-4 mb-4" style="border-top: 5px solid var(--ross-orange) !important;">
            <h5 class="fw-bold mb-3 font-serif" style="color: var(--ross-primary);">
                <i class="bi bi-arrow-repeat text-warning me-1"></i> Estado del Pedido
            </h5>

            <form action="{{ route('admin.pedidos.estado', $pedido) }}" method="POST">
                @csrf @method('PATCH')
                <div class="mb-3">
                    <label class="form-label small text-muted">Estado Actual:</label>
                    <select name="estado" class="form-select fw-bold">
                        @foreach(['pendiente','confirmado','preparando','enviado','entregado','cancelado'] as $e)
                            <option value="{{ $e }}" {{ $pedido->estado == $e ? 'selected' : '' }}>
                                {{ ucfirst($e) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-ross-primary w-100 py-2">
                    <i class="bi bi-check2-circle me-1"></i> Actualizar Estado
                </button>
            </form>
        </div>

        <!-- Customer Card -->
        <div class="card-ross p-4">
            <h5 class="fw-bold mb-3 font-serif" style="color: var(--ross-primary);">
                <i class="bi bi-person-lines-fill text-danger me-1"></i> Datos del Cliente
            </h5>

            <ul class="list-unstyled mb-0 small">
                <li class="mb-2">
                    <strong class="text-muted d-block">Nombre:</strong>
                    <span class="fs-6 fw-bold text-dark">{{ $pedido->user->name }}</span>
                </li>
                <li class="mb-2">
                    <strong class="text-muted d-block">Email:</strong>
                    <span>{{ $pedido->user->email }}</span>
                </li>
                <li class="mb-2">
                    <strong class="text-muted d-block">Teléfono / WhatsApp:</strong>
                    <span class="fw-semibold text-dark">{{ $pedido->telefono_contacto ?: 'No especificado' }}</span>
                </li>
                <li class="mb-2">
                    <strong class="text-muted d-block">Dirección de Entrega:</strong>
                    <span class="text-dark">{{ $pedido->direccion_entrega ?: 'No especificada' }}</span>
                </li>
                @if($pedido->notas)
                <li class="p-2 bg-light rounded-2 border">
                    <strong class="text-muted d-block">Notas de Cocina:</strong>
                    <em>{{ $pedido->notas }}</em>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection

