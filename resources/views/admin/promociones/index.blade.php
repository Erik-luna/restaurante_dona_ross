@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Gestión de Promociones')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Gestión de Promociones</h2>
        <p class="text-muted small mb-0">Configura descuentos, ofertas de temporada y combos especiales.</p>
    </div>
    <a href="{{ route('admin.promociones.create') }}" class="btn btn-ross-primary">
        <i class="bi bi-plus-circle-fill me-1"></i> Nueva Promoción
    </a>
</div>

<div class="table-card p-0 mb-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Promoción</th>
                    <th>Descuento</th>
                    <th>Vigencia</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promociones as $p)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($p->imagen)
                                <img src="{{ asset('storage/'.$p->imagen) }}" alt="{{ $p->titulo }}" class="rounded-3 shadow-sm" style="width: 48px; height: 48px; object-fit: cover;">
                            @else
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: var(--ross-orange-light); color: var(--ross-orange);">
                                    <i class="bi bi-tag-fill fs-5"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ $p->titulo }}</h6>
                                <small class="text-muted">{{ Str::limit($p->descripcion, 40) }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($p->descuento_porcentaje)
                            <span class="badge rounded-pill px-3 py-1" style="background: var(--ross-orange); color: white; font-weight: 600;">
                                {{ (int)$p->descuento_porcentaje }}% OFF
                            </span>
                        @else
                            <span class="badge bg-light text-dark border">Oferta Especial</span>
                        @endif
                    </td>
                    <td>
                        <span class="small text-dark fw-semibold">
                            {{ $p->fecha_inicio?->format('d/m/Y') ?? 'Inicio inmediato' }}
                        </span>
                        <small class="d-block text-muted">
                            hasta {{ $p->fecha_fin?->format('d/m/Y') ?? 'Sin fecha límite' }}
                        </small>
                    </td>
                    <td>
                        <span class="badge rounded-pill px-3 py-1 {{ $p->activo ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border' }}">
                            {{ $p->activo ? 'Activa' : 'Inactiva' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-1">
                            <a href="{{ route('admin.promociones.edit', $p) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <form action="{{ route('admin.promociones.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta promoción?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">No hay promociones registradas actualmente.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $promociones->links('pagination::bootstrap-5') }}
</div>
@endsection

