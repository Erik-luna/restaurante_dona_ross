@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Editar Promoción')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Editar: {{ $promocion->titulo }}</h2>
        <p class="text-muted small mb-0">Actualiza los descuentos, fechas de vigencia y arte de la promoción.</p>
    </div>
    <a href="{{ route('admin.promociones.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Volver a la lista
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-ross p-4 p-md-5">
            <form action="{{ route('admin.promociones.update', $promocion) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Título de la Promoción *</label>
                        <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $promocion->titulo) }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $promocion->descripcion) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Porcentaje de Descuento (%)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="descuento_porcentaje" class="form-control" value="{{ old('descuento_porcentaje', $promocion->descuento_porcentaje) }}">
                            <span class="input-group-text bg-white">%</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $promocion->fecha_inicio?->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Fecha de Finalización</label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ old('fecha_fin', $promocion->fecha_fin?->format('Y-m-d')) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Banner Promocional</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                        @if($promocion->imagen)
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <img src="{{ asset('storage/'.$promocion->imagen) }}" class="rounded shadow-sm" width="100" height="60" style="object-fit: cover;">
                                <small class="text-muted">Banner actual</small>
                            </div>
                        @endif
                    </div>

                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="form-check form-switch mb-0">
                                <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" {{ old('activo', $promocion->activo) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="activo">Promoción Activa</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-4 border-top mt-4">
                    <a href="{{ route('admin.promociones.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
                    <button type="submit" class="btn btn-ross-primary px-4">
                        <i class="bi bi-check-lg me-1"></i> Actualizar Promoción
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

