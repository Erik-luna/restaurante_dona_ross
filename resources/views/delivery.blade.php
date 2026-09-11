@extends('layouts.app')

@section('title', 'Solicitud Rápida de Delivery')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card-ross p-4 p-md-5 shadow-lg" style="border-top: 5px solid var(--ross-orange) !important;">
                <div class="text-center mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 65px; height: 65px; background: var(--ross-orange-light); color: var(--ross-orange);">
                        <i class="bi bi-bicycle fs-2"></i>
                    </div>
                    <h2 class="fw-bold font-serif mb-1" style="color: var(--ross-primary);">Pedido Rápido a Domicilio</h2>
                    <p class="text-muted small mb-0">Completa tus datos y enviaremos tu pedido calientito hasta tu puerta.</p>
                </div>

                <form action="{{ route('delivery.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nombre Completo *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                                    <i class="bi bi-person text-muted"></i>
                                </span>
                                <input type="text" name="cliente" class="form-control border-start-0 ps-0" placeholder="Ej: Juan Pérez" required style="border-radius: 0 12px 12px 0;">
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Dirección Exacta de Entrega *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                                    <i class="bi bi-geo-alt text-muted"></i>
                                </span>
                                <textarea name="direccion" class="form-control border-start-0 ps-0" rows="2" placeholder="Calle, número de casa, referencias o piso..." required style="border-radius: 0 12px 12px 0;"></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Selecciona tu Platillo *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                                    <i class="bi bi-egg-fried text-muted"></i>
                                </span>
                                <select name="pedido" class="form-select border-start-0 ps-0" required style="border-radius: 0 12px 12px 0;">
                                    <option value="Asado de Doña Ross">Asado Tradicional de Doña Ross</option>
                                    <option value="Sopa de Maní Especial">Sopa de Maní Especial de la Casa</option>
                                    <option value="Silpancho Tradicional">Silpancho Tradicional Cochabambino</option>
                                    <option value="Pique Macho Criollo">Pique Macho Criollo</option>
                                    <option value="Planchita Ross Especial">Planchita Ross Especial</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-ross-primary btn-lg w-100 py-3 shadow">
                            <i class="bi bi-send-fill me-1"></i> Confirmar y Enviar Pedido Delivery
                        </button>
                    </div>
                </form>

                <div class="text-center pt-3 border-top mt-4 text-muted small">
                    <p class="mb-0">
                        ¿Deseas pedir múltiples platillos o usar cupones? 
                        <a href="{{ route('catalogo') }}" class="text-danger fw-bold text-decoration-none">Visita el Catálogo Online</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection