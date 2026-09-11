@extends('layouts.app')

@section('title', 'Menú y Catálogo')

@section('content')
<div class="container pb-5">
    <!-- Header Banner -->
    <div class="section-header text-center mb-4">
        <span class="section-subtitle">Nuestra Carta Completa</span>
        <h1 class="section-title">Menú & Especialidades</h1>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            Platos tradicionales preparados al momento con el auténtico sazón casero de Doña Ross.
        </p>
        <div class="section-divider"></div>
    </div>

    <!-- Filter Card -->
    <div class="card-ross p-4 mb-4">
        <form method="GET" action="{{ route('catalogo') }}" class="row g-3 align-items-center">
            <div class="col-lg-5 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="buscar" class="form-control border-start-0 ps-0" placeholder="Buscar por nombre de plato..." value="{{ request('buscar') }}" style="border-radius: 0 12px 12px 0;">
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #D8D2C6;">
                        <i class="bi bi-filter text-muted"></i>
                    </span>
                    <select name="categoria" class="form-select border-start-0 ps-0" style="border-radius: 0 12px 12px 0;">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 d-flex gap-2">
                <button type="submit" class="btn btn-ross-primary flex-grow-1">
                    <i class="bi bi-funnel-fill"></i> Filtrar
                </button>
                @if(request('buscar') || request('categoria'))
                    <a href="{{ route('catalogo') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center px-3" style="border-radius: 30px;" title="Limpiar filtros">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    <div class="row g-4 mb-5">
        @forelse($productos as $producto)
        <div class="col-lg-4 col-md-6">
            <div class="card-ross h-100 d-flex flex-column">
                <div class="position-relative overflow-hidden" style="border-radius: var(--ross-radius) var(--ross-radius) 0 0;">
                    <img src="{{ $producto->imagen ? asset('storage/'.$producto->imagen) : asset('img/platos/plato' . (($loop->index % 5) + 1) . '.jpeg') }}" 
                         class="w-100" 
                         alt="{{ $producto->nombre }}" 
                         style="height: 240px; object-fit: cover; transition: transform 0.4s ease;"
                         onmouseover="this.style.transform='scale(1.06)'"
                         onmouseout="this.style.transform='scale(1)'">
                    
                    @if($producto->destacado)
                        <span class="position-absolute top-0 start-0 m-3 badge rounded-pill px-3 py-2 shadow-sm" style="background: var(--ross-orange); font-weight: 600;">
                            <i class="bi bi-star-fill text-warning me-1"></i> Destacado
                        </span>
                    @endif

                    @if($producto->stock <= 0)
                        <span class="position-absolute top-0 end-0 m-3 badge rounded-pill px-3 py-2 bg-danger shadow-sm">
                            <i class="bi bi-x-circle me-1"></i> Agotado
                        </span>
                    @elseif($producto->categoria)
                        <span class="position-absolute top-0 end-0 m-3 badge rounded-pill px-3 py-2 bg-dark bg-opacity-75 text-white shadow-sm">
                            {{ $producto->categoria->nombre }}
                        </span>
                    @endif
                </div>

                <div class="card-body p-4 d-flex flex-column flex-grow-1">
                    <h4 class="card-title fw-bold mb-2 font-serif" style="color: var(--ross-primary);">
                        {{ $producto->nombre }}
                    </h4>
                    
                    <p class="card-text text-muted small flex-grow-1 mb-3" style="line-height: 1.5;">
                        {{ $producto->descripcion ?: 'Delicioso plato tradicional preparado con el auténtico toque casero de Doña Ross.' }}
                    </p>

                    <div class="d-flex align-items-baseline justify-content-between mb-3">
                        <span class="fs-4 fw-bold" style="color: var(--ross-primary-dark);">
                            Bs. {{ number_format($producto->precio, 2) }}
                        </span>
                        @if($producto->stock > 0)
                            <span class="badge bg-success-subtle text-success small">
                                <i class="bi bi-check2"></i> Stock: {{ $producto->stock }}
                            </span>
                        @endif
                    </div>
                    
                    @if($producto->stock > 0)
                        @auth
                            @if(auth()->user()->isCliente())
                                <form action="{{ route('cliente.carrito.add', $producto) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-ross-primary w-100 py-2">
                                        <i class="bi bi-cart-plus-fill"></i> Agregar al Carrito
                                    </button>
                                </form>
                            @else
                                <div class="text-center py-1">
                                    <span class="text-muted small">Vista previa de cliente</span>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login.cliente') }}" class="btn btn-ross-outline w-100 py-2">
                                <i class="bi bi-box-arrow-in-right"></i> Ingresar para pedir
                            </a>
                        @endauth
                    @else
                        <button class="btn btn-secondary w-100 py-2 opacity-75" disabled>
                            <i class="bi bi-dash-circle"></i> No disponible por hoy
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="card-ross p-5 mx-auto" style="max-width: 500px;">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px; background: var(--ross-orange-light); color: var(--ross-orange);">
                    <i class="bi bi-search fs-2"></i>
                </div>
                <h4 class="fw-bold font-serif mb-2">No se encontraron platillos</h4>
                <p class="text-muted small mb-4">Intenta buscar con otro término o selecciona una categoría diferente.</p>
                <a href="{{ route('catalogo') }}" class="btn btn-ross-primary">
                    <i class="bi bi-arrow-clockwise"></i> Ver catálogo completo
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $productos->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection