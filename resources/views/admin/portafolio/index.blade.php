@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Gestión del Portafolio')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Gestión del Portafolio</h2>
        <p class="text-muted small mb-0">Administra los proyectos, habilidades y trayectoria profesional del sitio web.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('portafolio') }}" target="_blank" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> Ver Portafolio
        </a>
        <a href="{{ route('admin.portafolio.create') }}" class="btn btn-ross-primary">
            <i class="bi bi-plus-circle-fill me-1"></i> Agregar Sección
        </a>
    </div>
</div>

<div class="table-card p-0 mb-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 70px;">Orden</th>
                    <th>Tipo</th>
                    <th>Título / Contenido</th>
                    <th>Tecnologías / Enlace</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td class="fw-bold text-center text-muted">{{ $item->orden }}</td>
                    <td>
                        @php
                            $typeBadges = [
                                'proyecto' => 'bg-primary-subtle text-primary border border-primary',
                                'habilidad' => 'bg-warning-subtle text-warning-emphasis border border-warning',
                                'experiencia' => 'bg-success-subtle text-success border border-success',
                                'educacion' => 'bg-info-subtle text-info border border-info',
                                'sobre_mi' => 'bg-secondary-subtle text-secondary border',
                            ];
                        @endphp
                        <span class="badge rounded-pill px-3 py-1 {{ $typeBadges[$item->tipo] ?? 'bg-light text-dark' }}">
                            {{ ucfirst(str_replace('_', ' ', $item->tipo)) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($item->imagen)
                                <img src="{{ asset('storage/'.$item->imagen) }}" class="rounded shadow-sm" width="40" height="40" style="object-fit: cover;">
                            @endif
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ $item->titulo }}</h6>
                                <small class="text-muted">{{ Str::limit($item->descripcion, 40) }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($item->tecnologias)
                            <small class="fw-semibold text-dark d-block">{{ $item->tecnologias }}</small>
                        @endif
                        @if($item->enlace)
                            <a href="{{ $item->enlace }}" target="_blank" class="small text-danger text-decoration-none">
                                <i class="bi bi-link-45deg"></i> Ver Enlace
                            </a>
                        @endif
                    </td>
                    <td>
                        <span class="badge rounded-pill px-3 py-1 {{ $item->activo ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border' }}">
                            {{ $item->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-1">
                            <a href="{{ route('admin.portafolio.edit', $item) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <form action="{{ route('admin.portafolio.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este elemento?')">
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
                    <td colspan="6" class="text-center text-muted py-5">No hay elementos en el portafolio actualmente.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $items->links('pagination::bootstrap-5') }}
</div>
@endsection

