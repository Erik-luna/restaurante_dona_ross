@extends('layouts.admin')
@section('panel-title', auth()->user()->isAdmin() ? 'Administración' : 'Personal')
@section('sidebar')@include(auth()->user()->isAdmin() ? 'partials.sidebar-admin' : 'partials.sidebar-personal')@endsection
@section('title', 'Gestión de Clientes')

@section('content')
@php $prefix = auth()->user()->isAdmin() ? 'admin' : 'personal'; @endphp

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Gestión de Clientes</h2>
        <p class="text-muted small mb-0">Listado y directorio de clientes registrados en el restaurante.</p>
    </div>
    @if(! auth()->user()->isAdmin())
        <a href="{{ route($prefix.'.clientes.create') }}" class="btn btn-ross-primary">
            <i class="bi bi-person-plus-fill me-1"></i> Registrar Cliente
        </a>
    @endif
</div>

<div class="table-card p-0 mb-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 70px;"># ID</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $c)
                <tr>
                    <td class="fw-bold text-muted">#{{ $c->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white small" style="width: 38px; height: 38px; background: linear-gradient(135deg, var(--ross-primary) 0%, var(--ross-orange) 100%);">
                                {{ strtoupper(substr($c->name, 0, 1)) }}
                            </div>
                            <div>
                                <span class="fw-bold text-dark d-block">{{ $c->name }}</span>
                                <small class="text-muted">{{ Str::limit($c->direccion ?: 'Sin dirección', 25) }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $c->email }}</td>
                    <td>
                        @if($c->telefono)
                            <a href="https://wa.me/591{{ $c->telefono }}" target="_blank" class="text-decoration-none text-dark fw-semibold small">
                                <i class="bi bi-whatsapp text-success me-1"></i> {{ $c->telefono }}
                            </a>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge rounded-pill px-3 py-1 {{ $c->activo ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border' }}">
                            {{ $c->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="text-end">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.clientes.show', $c) }}" class="btn btn-sm btn-ross-primary rounded-pill px-3">
                                <i class="bi bi-eye"></i> Ver Detalle
                            </a>
                        @else
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route($prefix.'.clientes.edit', $c) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                                <form action="{{ route($prefix.'.clientes.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">No se encontraron clientes registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $clientes->links('pagination::bootstrap-5') }}
</div>
@endsection

