@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Directorio de Personal')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Personal del Restaurante</h2>
        <p class="text-muted small mb-0">Equipo de cocina, salón y atención al cliente.</p>
    </div>
</div>

<div class="table-card p-0 mb-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 70px;"># ID</th>
                    <th>Colaborador</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($personal as $p)
                <tr>
                    <td class="fw-bold text-muted">#{{ $p->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-dark small" style="width: 38px; height: 38px; background: var(--ross-gold);">
                                {{ strtoupper(substr($p->name, 0, 1)) }}
                            </div>
                            <div>
                                <span class="fw-bold text-dark d-block">{{ $p->name }}</span>
                                <span class="badge bg-secondary-subtle text-secondary small" style="font-size: 0.7rem;">Equipo de Atención</span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $p->email }}</td>
                    <td>
                        @if($p->telefono)
                            <a href="https://wa.me/591{{ $p->telefono }}" target="_blank" class="text-decoration-none text-dark fw-semibold small">
                                <i class="bi bi-telephone me-1 text-muted"></i> {{ $p->telefono }}
                            </a>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge rounded-pill px-3 py-1 {{ $p->activo ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border' }}">
                            {{ $p->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.personal.show', $p) }}" class="btn btn-sm btn-ross-primary rounded-pill px-3">
                            <i class="bi bi-eye"></i> Ver Detalle
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">No se encontró personal registrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $personal->links('pagination::bootstrap-5') }}
</div>
@endsection

