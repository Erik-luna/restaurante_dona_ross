@extends('layouts.admin')
@section('panel-title', 'Administración')
@section('sidebar')@include('partials.sidebar-admin')@endsection
@section('title', 'Horarios de Atención')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">Horarios de Atención</h2>
        <p class="text-muted small mb-0">Horarios operativos del salón y recepción de pedidos delivery.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-ross p-4 p-md-5">
            <h5 class="fw-bold mb-3 font-serif" style="color: var(--ross-primary);">
                <i class="bi bi-clock-history text-danger me-2"></i> Jornada de Atención al Público
            </h5>

            <div class="table-responsive mb-4">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Días</th>
                            <th class="border-0">Horario de Salón</th>
                            <th class="border-0">Servicio Delivery</th>
                            <th class="border-0 text-end">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold text-dark"><i class="bi bi-calendar-week text-danger me-2"></i> Lunes a Viernes</td>
                            <td>08:00 - 20:00</td>
                            <td><span class="text-success fw-semibold"><i class="bi bi-bicycle me-1"></i> Disponible</span></td>
                            <td class="text-end"><span class="badge bg-success-subtle text-success">Activo</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-dark"><i class="bi bi-calendar-week text-danger me-2"></i> Sábado</td>
                            <td>09:00 - 21:00</td>
                            <td><span class="text-success fw-semibold"><i class="bi bi-bicycle me-1"></i> Disponible</span></td>
                            <td class="text-end"><span class="badge bg-success-subtle text-success">Activo</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-dark"><i class="bi bi-calendar-week text-danger me-2"></i> Domingo</td>
                            <td>09:00 - 18:00</td>
                            <td><span class="text-success fw-semibold"><i class="bi bi-bicycle me-1"></i> Disponible</span></td>
                            <td class="text-end"><span class="badge bg-success-subtle text-success">Activo</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-3 bg-light rounded-3 border d-flex align-items-center gap-3">
                <i class="bi bi-info-circle-fill fs-3" style="color: var(--ross-orange);"></i>
                <small class="text-muted mb-0">
                    Los pedidos en línea recibidos fuera de estos horarios serán programados para el primer turno del siguiente día hábil.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

