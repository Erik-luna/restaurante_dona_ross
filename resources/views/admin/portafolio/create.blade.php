@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Agregar al Portafolio')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Nuevo Elemento de Portafolio</h2>
        <p class="text-muted small mb-0">Agrega proyectos, habilidades o trayectoria profesional a la sección de portafolio.</p>
    </div>
    <a href="{{ route('admin.portafolio.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Volver a la lista
    </a>
</div>

<div class="card-ross p-4 p-md-5">
    <form action="{{ route('admin.portafolio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Tipo de Sección *</label>
                <select name="tipo" class="form-select" required>
                    @foreach(['proyecto' => 'Proyecto Destacado', 'habilidad' => 'Habilidad Técnica', 'experiencia' => 'Experiencia Laboral', 'educacion' => 'Educación y Certificaciones', 'sobre_mi' => 'Sobre Mí'] as $t => $label)
                        <option value="{{ $t }}" {{ old('tipo') == $t ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Título *</label>
                <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" placeholder="Ej: Sistema de Pedidos y Delivery Doña Ross" required>
            </div>

            <div class="col-12">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="4" placeholder="Detalles, responsabilidades, logros o descripción general...">{{ old('descripcion') }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tecnologías / Herramientas</label>
                <input type="text" name="tecnologias" class="form-control" value="{{ old('tecnologias') }}" placeholder="Ej: PHP 8, Laravel 11, Bootstrap 5, MySQL">
            </div>

            <div class="col-md-6">
                <label class="form-label">Enlace URL (Demo o Repositorio)</label>
                <input type="url" name="enlace" class="form-control" value="{{ old('enlace') }}" placeholder="https://github.com/...">
            </div>

            <div class="col-md-4">
                <label class="form-label">Orden de Visualización</label>
                <input type="number" name="orden" class="form-control" value="{{ old('orden', 0) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Imagen o Captura</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
            </div>

            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 border mt-1">
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" checked>
                        <label class="form-check-label fw-semibold" for="activo">Elemento Activo</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-4 border-top mt-4">
            <a href="{{ route('admin.portafolio.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
            <button type="submit" class="btn btn-ross-primary px-4">
                <i class="bi bi-check-lg me-1"></i> Guardar Elemento
            </button>
        </div>
    </form>
</div>
@endsection

