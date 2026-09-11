@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Gestión de Productos')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Catálogo de Productos</h2>
        <p class="text-muted small mb-0">Administra los platillos, precios, categorías y disponibilidad en el menú.</p>
    </div>
    <a href="{{ route('admin.productos.create') }}" class="btn btn-ross-primary">
        <i class="bi bi-plus-circle-fill me-1"></i> Nuevo Producto
    </a>
</div>

<div class="table-card p-0 mb-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 70px;">#</th>
                    <th>Platillo</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $p)
                <tr>
                    <td class="fw-bold text-muted">{{ $p->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $p->imagen ? asset('storage/'.$p->imagen) : asset('img/platos/plato' . (($loop->index % 5) + 1) . '.jpeg') }}" 
                                 alt="{{ $p->nombre }}" 
                                 class="rounded-3 shadow-sm" 
                                 style="width: 48px; height: 48px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ $p->nombre }}</h6>
                                @if($p->destacado)
                                    <span class="badge badge-ross-gold text-dark small" style="font-size: 0.68rem;">
                                        <i class="bi bi-star-fill text-warning"></i> Destacado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $p->categoria->nombre ?? 'Sin categoría' }}
                        </span>
                    </td>
                    <td class="fw-bold" style="color: var(--ross-primary);">
                        Bs. {{ number_format($p->precio, 2) }}
                    </td>
                    <td>
                        @if($p->stock > 10)
                            <span class="badge bg-success-subtle text-success">{{ $p->stock }} u.</span>
                        @elseif($p->stock > 0)
                            <span class="badge bg-warning-subtle text-warning-emphasis">{{ $p->stock }} u. (Bajo)</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger">Agotado (0)</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge rounded-pill px-3 py-1 {{ $p->activo ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border' }}">
                            {{ $p->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-1">
                            <a href="{{ route('admin.productos.edit', $p) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Editar">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <form action="{{ route('admin.productos.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Eliminar">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">No hay productos registrados en el sistema.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $productos->links('pagination::bootstrap-5') }}
</div>
@endsection

