@extends('layouts.app')

@section('title', 'Portafolio Profesional')

@section('content')
<div class="container pb-5">
    <!-- Hero Profile Section -->
    <div class="card-ross p-4 p-md-5 mb-5 text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #FFFFFF 0%, #FDFBF7 100%);">
        <div class="position-relative mx-auto mb-4" style="width: 140px; height: 140px;">
            <img src="{{ asset('img/mi-foto.png') }}" alt="Foto de perfil" class="rounded-circle shadow-md w-100 h-100" style="object-fit: cover; border: 4px solid var(--ross-gold);">
            <span class="position-absolute bottom-0 end-0 p-2 rounded-circle bg-success border border-white border-2" title="Disponible para proyectos"></span>
        </div>

        <span class="badge badge-ross-orange px-3 py-2 rounded-pill fw-bold mb-2">
            <i class="bi bi-code-slash me-1"></i> DESARROLLADOR WEB & SISTEMAS
        </span>

        <h1 class="display-5 fw-bold mb-3 font-serif" style="color: var(--ross-primary);">
            Mi Portafolio
        </h1>

        @if($sobreMi)
            <p class="lead mx-auto text-muted mb-4" style="max-width: 720px; line-height: 1.6;">
                {{ $sobreMi->descripcion ?? $sobreMi->titulo }}
            </p>
        @else
            <p class="lead mx-auto text-muted mb-4" style="max-width: 720px; line-height: 1.6;">
                Estudiante y desarrollador apasionado por crear aplicaciones web completas, modernas y escalables con Laravel, PHP, MySQL y tecnologías de frontend.
            </p>
        @endif

        <div class="d-flex justify-content-center gap-2">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.portafolio.index') }}" class="btn btn-ross-primary btn-sm px-4">
                        <i class="bi bi-gear-fill me-1"></i> Administrar Portafolio
                    </a>
                @endif
            @else
                <a href="{{ route('login.admin') }}" class="btn btn-ross-outline btn-sm px-4">
                    <i class="bi bi-shield-lock me-1"></i> Acceso Admin
                </a>
            @endauth
        </div>
    </div>

    <!-- Habilidades -->
    @if($habilidades->count())
    <div class="mb-5">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-tools fs-4 text-danger"></i>
            <h3 class="fw-bold mb-0 font-serif" style="color: var(--ross-primary);">Habilidades & Tecnologías</h3>
        </div>
        <div class="d-flex flex-wrap gap-2">
            @foreach($habilidades as $h)
                <span class="badge px-3 py-2 rounded-pill fs-6" style="background: white; color: var(--ross-primary); border: 1.5px solid var(--ross-border); box-shadow: var(--ross-shadow-sm);">
                    <i class="bi bi-check2-circle text-danger me-1"></i> {{ $h->titulo }}
                </span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Proyectos -->
    @if($proyectos->count())
    <div class="mb-5">
        <div class="d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-kanban fs-4 text-warning"></i>
            <h3 class="fw-bold mb-0 font-serif" style="color: var(--ross-primary);">Proyectos Destacados</h3>
        </div>
        <div class="row g-4">
            @foreach($proyectos as $p)
            <div class="col-lg-4 col-md-6">
                <div class="card-ross h-100 d-flex flex-column">
                    @if($p->imagen)
                        <img src="{{ asset('storage/'.$p->imagen) }}" class="card-img-top" alt="{{ $p->titulo }}" style="height: 190px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="height: 160px; border-bottom: 1px solid var(--ross-border);">
                            <i class="bi bi-laptop fs-1 opacity-50"></i>
                        </div>
                    @endif
                    <div class="card-body p-4 d-flex flex-column flex-grow-1">
                        <h5 class="card-title fw-bold font-serif mb-2" style="color: var(--ross-primary);">{{ $p->titulo }}</h5>
                        <p class="card-text text-muted small flex-grow-1 mb-3" style="line-height: 1.5;">{{ $p->descripcion }}</p>
                        @if($p->tecnologias)
                            <div class="mb-3">
                                <span class="badge bg-light text-dark border small">
                                    <i class="bi bi-cpu me-1"></i> {{ $p->tecnologias }}
                                </span>
                            </div>
                        @endif
                        @if($p->enlace)
                            <a href="{{ $p->enlace }}" target="_blank" class="btn btn-ross-outline btn-sm w-100 mt-auto">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Ver Proyecto
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Experiencia y Educación en 2 Columnas -->
    <div class="row g-4">
        @if($experiencias->count())
        <div class="col-lg-6">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-briefcase fs-4 text-danger"></i>
                <h3 class="fw-bold mb-0 font-serif" style="color: var(--ross-primary);">Experiencia Laboral</h3>
            </div>
            <div class="d-flex flex-column gap-3">
                @foreach($experiencias as $e)
                <div class="card-ross p-4" style="border-left: 5px solid var(--ross-orange) !important;">
                    <h5 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">{{ $e->titulo }}</h5>
                    <p class="text-muted small mb-0">{{ $e->descripcion }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($educacion->count())
        <div class="col-lg-6">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-mortarboard fs-4 text-warning"></i>
                <h3 class="fw-bold mb-0 font-serif" style="color: var(--ross-primary);">Educación & Formación</h3>
            </div>
            <div class="d-flex flex-column gap-3">
                @foreach($educacion as $ed)
                <div class="card-ross p-4" style="border-left: 5px solid var(--ross-gold) !important;">
                    <h5 class="fw-bold mb-1 font-serif" style="color: var(--ross-primary);">{{ $ed->titulo }}</h5>
                    <p class="text-muted small mb-0">{{ $ed->descripcion }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection