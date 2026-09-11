@extends('layouts.admin')
@section('panel-title', auth()->user()->isAdmin() ? 'Administración' : 'Personal')
@section('sidebar')@include(auth()->user()->isAdmin() ? 'partials.sidebar-admin' : 'partials.sidebar-personal')@endsection
@section('title', 'Comprobante de Venta #'.$venta->id)

@section('content')
@php $prefix = auth()->user()->isAdmin() ? 'admin' : 'personal'; @endphp

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Comprobante de Venta #{{ $venta->id }}</h2>
        <p class="text-muted small mb-0">Emitido el {{ $venta->created_at->format('d/m/Y \a \l\a\s H:i') }} hrs</p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-printer me-1"></i> Imprimir Ticket
        </button>
        <a href="{{ route($prefix.'.ventas.index') }}" class="btn btn-ross-primary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Volver a Ventas
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-ross p-4 p-md-5 shadow-lg" style="border-top: 5px solid var(--ross-orange) !important;">
            <!-- Header Ticket -->
            <div class="text-center pb-4 mb-4 border-bottom">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="brand-logo-img mb-2" style="width: 50px; height: 50px;">
                <h4 class="fw-bold font-serif mb-0" style="color: var(--ross-primary);">Doña Ross Restaurant</h4>
                <p class="text-muted small mb-1">Sabor Tradicional & Especialidades</p>
                <span class="badge badge-ross-gold text-dark px-3 py-1 fw-bold">TICKET DE VENTA LOCAL #{{ $venta->id }}</span>
            </div>

            <!-- Meta info grid -->
            <div class="row g-3 mb-4 small">
                <div class="col-sm-6">
                    <span class="text-muted d-block">Cliente:</span>
                    <strong class="fs-6 text-dark">{{ $venta->user->name ?? 'Cliente General' }}</strong>
                    <div class="text-muted">{{ $venta->user->email ?? '-' }}</div>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <span class="text-muted d-block">Atendido por:</span>
                    <strong class="text-dark">{{ $venta->atendidoPor->name ?? 'Caja' }}</strong>
                    <div class="text-muted">{{ $venta->created_at->format('d/m/Y H:i') }}</div>
                </div>
                @if($venta->notas)
                <div class="col-12">
                    <div class="p-2 bg-light rounded-2 border">
                        <strong class="text-muted">Observaciones:</strong> {{ $venta->notas }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Items Table -->
            <div class="table-responsive mb-4">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Platillo / Ítem</th>
                            <th class="border-0 text-center">Cantidad</th>
                            <th class="border-0 text-end">Precio Unit.</th>
                            <th class="border-0 text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($venta->items as $item)
                        <tr>
                            <td>
                                <span class="fw-bold text-dark">{{ $item->producto->nombre }}</span>
                            </td>
                            <td class="text-center fw-bold">{{ $item->cantidad }}</td>
                            <td class="text-end text-muted">Bs. {{ number_format($item->precio_unitario, 2) }}</td>
                            <td class="text-end fw-bold" style="color: var(--ross-primary);">
                                Bs. {{ number_format($item->subtotal, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end border-0 pt-3 fs-5 font-serif">Total Pagado:</th>
                            <th class="text-end border-0 pt-3 fs-4 fw-bold" style="color: var(--ross-primary-dark);">
                                Bs. {{ number_format($venta->total, 2) }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-center pt-3 border-top text-muted small">
                <p class="mb-0">¡Gracias por su preferencia! Que disfrute su comida.</p>
            </div>
        </div>
    </div>
</div>
@endsection

