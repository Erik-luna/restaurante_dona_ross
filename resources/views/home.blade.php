@extends('layouts.app')

@section('title', 'Sabor Casero y Tradición')

@section('content')
<div class="container pb-5">
    <!-- Hero Section -->
    <div class="card border-0 rounded-4 overflow-hidden mb-5 shadow-lg position-relative" style="background: linear-gradient(135deg, rgba(30, 5, 6, 0.88) 0%, rgba(90, 11, 13, 0.75) 50%, rgba(255, 87, 34, 0.45) 100%), url('{{ asset('img/platos/plato1.jpeg') }}') center/cover; min-height: 480px;">
        <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-center text-white my-auto">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(255, 179, 0, 0.2); border: 1px solid rgba(255, 179, 0, 0.5); backdrop-filter: blur(8px);">
                        <i class="bi bi-stars text-warning"></i>
                        <span class="text-warning fw-semibold small text-uppercase" style="letter-spacing: 1.5px;">El auténtico sabor casero</span>
                    </div>

                    <h1 class="display-4 fw-bold mb-3 text-white" style="line-height: 1.2;">
                        Tradición y Pasión <br>
                        <span style="color: var(--ross-gold); font-style: italic;">en Cada Platillo</span>
                    </h1>

                    <p class="lead mb-4 text-white-50 fs-5" style="max-width: 600px;">
                        Descubre las mejores recetas familiares preparadas con ingredientes frescos del día. Sabor inigualable que te hará sentir como en casa.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('catalogo') }}" class="btn btn-ross-primary btn-lg px-4">
                            <i class="bi bi-egg-fried fs-5"></i> Explorar Catálogo
                        </a>
                        <a href="{{ route('promociones') }}" class="btn btn-ross-gold btn-lg px-4">
                            <i class="bi bi-tag-fill fs-5"></i> Ver Promociones
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 d-none d-lg-block text-center">
                    <div class="p-4 rounded-4 text-start" style="background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.15);">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: var(--ross-orange);">
                                <i class="bi bi-bicycle text-white fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-white fw-bold">Delivery Rápido</h6>
                                <small class="text-white-50">Directo a tu mesa o domicilio</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: var(--ross-gold);">
                                <i class="bi bi-shield-check text-dark fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-white fw-bold">100% Calidad Casera</h6>
                                <small class="text-white-50">Recetas con sazón de hogar</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Pillars -->
    <div class="row g-4 mb-5">
        <div class="col-md-3 col-sm-6">
            <div class="card-ross h-100 p-4 text-center">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background-color: var(--ross-orange-light); color: var(--ross-orange);">
                    <i class="bi bi-fire fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2">Recetas Auténticas</h5>
                <p class="text-muted small mb-0">Preparadas con el toque tradicional y familiar que nos caracteriza.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card-ross h-100 p-4 text-center">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background-color: #E8F8F0; color: #10B981;">
                    <i class="bi bi-patch-check-fill fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2">Ingredientes Frescos</h5>
                <p class="text-muted small mb-0">Seleccionamos los mejores insumos día a día para garantizar la excelencia.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card-ross h-100 p-4 text-center">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background-color: var(--ross-gold-light); color: #B45309;">
                    <i class="bi bi-truck fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2">Delivery Confiable</h5>
                <p class="text-muted small mb-0">Llevamos tus platos favoritos calientes y listos para disfrutar.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card-ross h-100 p-4 text-center">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background-color: #EBF5FF; color: #2563EB;">
                    <i class="bi bi-credit-card-2-front-fill fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2">Pedidos Online</h5>
                <p class="text-muted small mb-0">Haz tu pedido fácil y rápido desde tu computadora o teléfono celular.</p>
            </div>
        </div>
    </div>

    <!-- Platos Destacados Section -->
    @if($destacados->count())
    <div class="section-header text-center">
        <span class="section-subtitle">Lo más pedido</span>
        <h2 class="section-title">Nuestras Especialidades</h2>
        <div class="section-divider"></div>
    </div>

    <div class="row g-4 mb-5">
        @foreach($destacados as $producto)
        <div class="col-lg-4 col-md-6">
            <div class="card-ross h-100 d-flex flex-column">
                <div class="position-relative overflow-hidden" style="border-radius: var(--ross-radius) var(--ross-radius) 0 0;">
                    <img src="{{ $producto->imagen ? asset('storage/'.$producto->imagen) : asset('img/platos/plato' . (($loop->index % 5) + 1) . '.jpeg') }}" 
                         class="w-100" 
                         alt="{{ $producto->nombre }}" 
                         style="height: 230px; object-fit: cover; transition: transform 0.4s ease;"
                         onmouseover="this.style.transform='scale(1.06)'"
                         onmouseout="this.style.transform='scale(1)'">
                    
                    <span class="position-absolute top-0 start-0 m-3 badge rounded-pill px-3 py-2 shadow-sm" style="background: var(--ross-orange); font-weight: 600;">
                        <i class="bi bi-star-fill me-1 text-warning"></i> Destacado
                    </span>

                    @if($producto->categoria)
                        <span class="position-absolute bottom-0 end-0 m-3 badge rounded-pill px-3 py-2 shadow-sm bg-dark bg-opacity-75 text-white">
                            {{ $producto->categoria->nombre }}
                        </span>
                    @endif
                </div>
                
                <div class="card-body p-4 d-flex flex-column flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h4 class="fw-bold mb-0 font-serif" style="color: var(--ross-primary);">{{ $producto->nombre }}</h4>
                    </div>
                    
                    <p class="text-muted small flex-grow-1 mb-3" style="line-height: 1.5;">
                        {{ Str::limit($producto->descripcion, 90) }}
                    </p>

                    <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle">
                        <div>
                            <span class="text-muted small d-block">Precio</span>
                            <span class="fs-4 fw-bold" style="color: var(--ross-primary-dark);">
                                Bs. {{ number_format($producto->precio, 2) }}
                            </span>
                        </div>

                        @auth
                            @if(auth()->user()->isCliente() && $producto->stock > 0)
                                <form action="{{ route('cliente.carrito.add', $producto) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-ross-primary btn-sm px-3">
                                        <i class="bi bi-cart-plus-fill"></i> Pedir
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('catalogo') }}" class="btn btn-ross-outline btn-sm">
                                    Ver menú
                                </a>
                            @endif
                        @else
                            <a href="{{ route('catalogo') }}" class="btn btn-ross-outline btn-sm">
                                Ver detalle
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mb-5">
        <a href="{{ route('catalogo') }}" class="btn btn-ross-secondary btn-lg px-5">
            <i class="bi bi-grid-3x3-gap-fill me-2 text-warning"></i> Ver Todo el Menú y Carta
        </a>
    </div>
    @endif

    <!-- Promo Highlight Banner -->
    <div class="card border-0 rounded-4 overflow-hidden mb-5 text-white shadow" style="background: linear-gradient(135deg, var(--ross-primary) 0%, #4D090B 100%); border-left: 8px solid var(--ross-gold) !important;">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge badge-ross-gold text-dark mb-2 px-3 py-2 fw-bold">
                        <i class="bi bi-percent me-1"></i> AHORRA MÁS
                    </span>
                    <h2 class="display-6 fw-bold mb-2 font-serif text-white">¿Buscas descuentos especiales?</h2>
                    <p class="text-white-50 mb-4 mb-lg-0 fs-5">
                        Aprovecha nuestros combos familiares, promociones del día y descuentos por compras online.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('promociones') }}" class="btn btn-ross-gold btn-lg px-4 shadow">
                        <i class="bi bi-fire me-1"></i> Ver Promociones
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Info Cards -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card-ross h-100 p-4 d-flex flex-row align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px; background-color: var(--ross-orange-light); color: var(--ross-orange);">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1 font-serif">Horario de Atención</h5>
                    <p class="text-muted small mb-0">Lunes a Domingo: 08:00 a 20:00</p>
                    <span class="badge bg-success-subtle text-success small">Abierto ahora</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-ross h-100 p-4 d-flex flex-row align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px; background-color: var(--ross-gold-light); color: #B45309;">
                    <i class="bi bi-geo-alt-fill fs-3"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1 font-serif">Nuestra Ubicación</h5>
                    <p class="text-muted small mb-0">Av. Principal #123, Zona Central</p>
                    <span class="text-warning small fw-bold">Fácil acceso y parqueo</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-ross h-100 p-4 d-flex flex-row align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px; background-color: #E8F8F0; color: #10B981;">
                    <i class="bi bi-whatsapp fs-3"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1 font-serif">Pedidos Directos</h5>
                    <p class="text-muted small mb-0">+591 70000000</p>
                    <a href="https://wa.me/59170000000" target="_blank" class="text-success small fw-bold text-decoration-none">Escribir por WhatsApp &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection