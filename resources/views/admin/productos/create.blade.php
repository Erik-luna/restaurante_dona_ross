@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Nuevo Producto')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Nuevo Producto</h2>
        <p class="text-muted small mb-0">Agrega un nuevo platillo al menú y catálogo del restaurante.</p>
    </div>
    <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Volver a la lista
    </a>
</div>

<div class="card-ross p-4 p-md-5">
    <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre del Platillo *</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ej: Silpancho Tradicional" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Categoría</label>
                <select name="categoria_id" class="form-select">
                    <option value="">Seleccionar categoría...</option>
                    @foreach($categorias as $c)
                        <option value="{{ $c->id }}" {{ old('categoria_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" placeholder="Ingredientes principales, preparación, acompañamientos...">{{ old('descripcion') }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">Precio Unitario (Bs.) *</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">Bs.</span>
                    <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio') }}" placeholder="0.00" required>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Stock Disponible *</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', 10) }}" min="0" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Fotografía del Plato</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 border">
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" name="destacado" value="1" class="form-check-input" id="destacado" {{ old('destacado') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="destacado">Plato Destacado (Aparece en inicio)</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 border">
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" checked>
                        <label class="form-check-label fw-semibold" for="activo">Platillo Activo (Visible para clientes)</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-4 border-top mt-4">
            <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
            <button type="submit" class="btn btn-ross-primary px-4">
                <i class="bi bi-check-lg me-1"></i> Guardar Producto
            </button>
        </div>
    </form>
</div>
@endsection

