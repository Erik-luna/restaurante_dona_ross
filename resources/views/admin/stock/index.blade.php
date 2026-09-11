@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Control de Stock')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Control de Stock</h2>
        <p class="text-muted small mb-0">Monitorea y actualiza rápidamente el inventario disponible de cada platillo.</p>
    </div>
</div>

<div class="table-card p-0 mb-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 70px;"># ID</th>
                    <th>Platillo</th>
                    <th>Estado de Disponibilidad</th>
                    <th style="width: 250px;">Ajustar Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $p)
                <tr>
                    <td class="fw-bold text-muted">#{{ $p->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $p->imagen ? asset('storage/'.$p->imagen) : asset('img/platos/plato' . (($loop->index % 5) + 1) . '.jpeg') }}" 
                                 alt="{{ $p->nombre }}" 
                                 class="rounded-3 shadow-sm" 
                                 style="width: 44px; height: 44px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ $p->nombre }}</h6>
                                <small class="text-muted">{{ $p->categoria->nombre ?? 'Menú General' }} &bull; Bs. {{ number_format($p->precio, 2) }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($p->stock > 10)
                            <span class="badge bg-success-subtle text-success border border-success px-3 py-1">
                                <i class="bi bi-check-circle me-1"></i> {{ $p->stock }} unidades disponibles
                            </span>
                        @elseif($p->stock > 0)
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning px-3 py-1">
                                <i class="bi bi-exclamation-triangle me-1"></i> Stock Bajo ({{ $p->stock }} u.)
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-1">
                                <i class="bi bi-x-circle me-1"></i> Agotado (0 u.)
                            </span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.stock.update', $p) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf @method('PUT')
                            <input type="number" name="stock" value="{{ $p->stock }}" min="0" class="form-control text-center fw-bold" style="width: 100px;">
                            <button type="submit" class="btn btn-sm btn-ross-secondary rounded-pill px-3">
                                <i class="bi bi-save"></i> Guardar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-5">No hay productos en inventario.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

