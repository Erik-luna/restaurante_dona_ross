@extends('layouts.app')

@section('title', 'Promociones y Ofertas')

@section('content')
<div class="container pb-5">
    <!-- Header Banner -->
    <div class="section-header text-center mb-5">
        <span class="section-subtitle">Ahorra y Disfruta</span>
        <h1 class="section-title">Promociones & Descuentos Especiales</h1>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            Aprovecha nuestros combos y descuentos exclusivos en platillos tradicionales.
        </p>
        <div class="section-divider"></div>
    </div>

    <div class="row g-4">
        @forelse($promociones as $promo)
        <div class="col-lg-6">
            <div class="card-ross h-100 p-0 overflow-hidden position-relative" style="border-left: 6px solid var(--ross-orange) !important;">
                <div class="row g-0 h-100">
                    <div class="{{ $promo->imagen ? 'col-sm-7' : 'col-12' }} p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                @if($promo->descuento_porcentaje)
                                    <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: linear-gradient(135deg, var(--ross-orange) 0%, #E64A19 100%); color: white; font-size: 0.85rem;">
                                        <i class="bi bi-tag-fill me-1"></i> {{ (int)$promo->descuento_porcentaje }}% OFF
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: var(--ross-gold); color: #5A0B0D; font-size: 0.85rem;">
                                        <i class="bi bi-stars me-1"></i> Oferta Especial
                                    </span>
                                @endif

                                @if($promo->fecha_fin)
                                    <span class="badge bg-light text-muted border">
                                        <i class="bi bi-calendar3 me-1"></i> Hasta {{ $promo->fecha_fin->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="fw-bold mb-2 font-serif" style="color: var(--ross-primary);">
                                {{ $promo->titulo }}
                            </h3>

                            <p class="text-muted small mb-3" style="line-height: 1.6;">
                                {{ $promo->descripcion }}
                            </p>
                        </div>

                        <div class="pt-3 border-top border-light-subtle">
                            @auth
                                @if(auth()->user()->isCliente())
                                    <a href="{{ route('catalogo') }}" class="btn btn-ross-primary btn-sm px-4">
                                        <i class="bi bi-bag-plus-fill me-1"></i> Aprovechar Oferta
                                    </a>
                                @else
                                    <a href="{{ route('catalogo') }}" class="btn btn-ross-outline btn-sm">
                                        Ver en Menú
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="btn btn-ross-primary btn-sm px-4">
                                    <i class="bi bi-person-plus-fill me-1"></i> Regístrate y Pide
                                </a>
                            @endauth
                        </div>
                    </div>

                    @if($promo->imagen)
                    <div class="col-sm-5 d-none d-sm-block">
                        <img src="{{ asset('storage/'.$promo->imagen) }}" class="w-100 h-100" style="object-fit: cover; min-height: 220px;" alt="{{ $promo->titulo }}">
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="card-ross p-5 mx-auto" style="max-width: 500px;">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px; background: var(--ross-gold-light); color: #B45309;">
                    <i class="bi bi-gift fs-2"></i>
                </div>
                <h4 class="fw-bold font-serif mb-2">Próximamente Nuevas Promociones</h4>
                <p class="text-muted small mb-4">Estamos preparando increíbles ofertas y descuentos para ti. ¡Visítanos pronto o explora nuestro menú!</p>
                <a href="{{ route('catalogo') }}" class="btn btn-ross-primary">
                    <i class="bi bi-egg-fried me-1"></i> Explorar Catálogo
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

