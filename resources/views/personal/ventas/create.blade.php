@extends('layouts.admin')
@section('panel-title', auth()->user()->isAdmin() ? 'Administración' : 'Personal')
@section('sidebar')@include(auth()->user()->isAdmin() ? 'partials.sidebar-admin' : 'partials.sidebar-personal')@endsection
@section('title', 'Registrar Venta Local')

@section('content')
@php $prefix = auth()->user()->isAdmin() ? 'admin' : 'personal'; @endphp

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Nueva Venta Local / Salón</h2>
        <p class="text-muted small mb-0">Selecciona el cliente y añade los platillos ordenados.</p>
    </div>
    <a href="{{ route($prefix.'.ventas.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Volver a la lista
    </a>
</div>

<form action="{{ route($prefix.'.ventas.store') }}" method="POST" id="ventaForm">
    @csrf
    <div class="row g-4">
        <!-- Customer & Order details -->
        <div class="col-lg-5">
            <div class="card-ross p-4 mb-4" style="border-top: 5px solid var(--ross-primary) !important;">
                <h5 class="fw-bold mb-3 font-serif" style="color: var(--ross-primary);">
                    <i class="bi bi-person-check text-danger me-2"></i> Datos del Comprobante
                </h5>

                <div class="mb-3">
                    <label class="form-label">Cliente *</label>
                    <select name="user_id" class="form-select" required>
                        <option value="">Seleccionar cliente...</option>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}" {{ old('user_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->name }} ({{ $c->email }})
                            </option>
                        @endforeach
                    </select>
                    <div class="mt-2">
                        <a href="{{ route($prefix.'.clientes.create') }}" class="text-danger small text-decoration-none fw-semibold">
                            <i class="bi bi-person-plus me-1"></i> ¿Cliente nuevo? Registrar aquí
                        </a>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notas u Observaciones</label>
                    <input type="text" name="notas" class="form-control" value="{{ old('notas') }}" placeholder="Ej: Mesa 4, sin picante, etc.">
                </div>

                <div class="p-3 bg-light rounded-3 border mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-muted small">Atendido por:</span>
                        <span class="fw-bold text-dark">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Fecha:</span>
                        <span class="fw-semibold text-dark">{{ date('d/m/Y') }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-ross-primary btn-lg w-100 py-3 shadow">
                        <i class="bi bi-receipt-cutoff me-1"></i> Registrar y Cobrar Venta
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Builder -->
        <div class="col-lg-7">
            <div class="card-ross p-4" style="border-top: 5px solid var(--ross-orange) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 font-serif" style="color: var(--ross-primary);">
                        <i class="bi bi-cart3 text-warning me-2"></i> Platillos de la Orden
                    </h5>
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" id="addItem">
                        <i class="bi bi-plus-lg me-1"></i> Agregar Platillo
                    </button>
                </div>

                <div id="itemsContainer" class="mb-3">
                    <div class="p-3 bg-light rounded-3 border item-row mb-2">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-7">
                                <label class="form-label small text-muted mb-1">Platillo / Bebida</label>
                                <select name="items[0][producto_id]" class="form-select producto-select" required>
                                    <option value="">Seleccionar platillo...</option>
                                    @foreach($productos as $p)
                                        <option value="{{ $p->id }}" data-precio="{{ $p->precio }}">
                                            {{ $p->nombre }} — Bs. {{ number_format($p->precio, 2) }} (Stock: {{ $p->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small text-muted mb-1">Cantidad</label>
                                <input type="number" name="items[0][cantidad]" class="form-control text-center fw-bold cantidad-input" min="1" value="1" required>
                            </div>
                            <div class="col-md-2 text-end pt-4">
                                <button type="button" class="btn btn-outline-secondary btn-remove w-100" disabled>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
let itemIndex = 1;
const productosOptions = `@foreach($productos as $p)<option value="{{ $p->id }}" data-precio="{{ $p->precio }}">{{ $p->nombre }} — Bs. {{ number_format($p->precio, 2) }} (Stock: {{ $p->stock }})</option>@endforeach`;

document.getElementById('addItem').addEventListener('click', function() {
    const row = document.createElement('div');
    row.className = 'p-3 bg-light rounded-3 border item-row mb-2';
    row.innerHTML = `
        <div class="row g-2 align-items-center">
            <div class="col-md-7">
                <label class="form-label small text-muted mb-1">Platillo / Bebida</label>
                <select name="items[${itemIndex}][producto_id]" class="form-select producto-select" required>
                    <option value="">Seleccionar platillo...</option>
                    ${productosOptions}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Cantidad</label>
                <input type="number" name="items[${itemIndex}][cantidad]" class="form-control text-center fw-bold cantidad-input" min="1" value="1" required>
            </div>
            <div class="col-md-2 text-end pt-4">
                <button type="button" class="btn btn-outline-danger btn-remove w-100">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>`;
    document.getElementById('itemsContainer').appendChild(row);
    itemIndex++;
});

document.getElementById('itemsContainer').addEventListener('click', function(e) {
    if (e.target.closest('.btn-remove')) {
        const itemRows = document.querySelectorAll('.item-row');
        if (itemRows.length > 1) {
            e.target.closest('.item-row').remove();
        }
    }
});
</script>
@endpush

