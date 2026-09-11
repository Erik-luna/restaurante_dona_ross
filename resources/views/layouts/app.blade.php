<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doña Ross - @yield('title', 'Sabor Casero')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo.jpeg') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --ross-primary: #7A1113;
            --ross-primary-dark: #5A0B0D;
            --ross-primary-light: #9B1C1F;
            --ross-orange: #FF5722;
            --ross-orange-hover: #E64A19;
            --ross-orange-light: #FFEDE6;
            --ross-gold: #FFB300;
            --ross-gold-dark: #E59800;
            --ross-gold-light: #FFF8E1;
            --ross-bg: #FCFAF7;
            --ross-surface: #FFFFFF;
            --ross-text: #212529;
            --ross-text-muted: #6C757D;
            --ross-border: #EAE3D9;
            --ross-shadow-sm: 0 2px 8px rgba(122, 17, 19, 0.06);
            --ross-shadow: 0 10px 30px rgba(122, 17, 19, 0.08);
            --ross-shadow-lg: 0 20px 40px rgba(122, 17, 19, 0.12);
            --ross-radius-sm: 10px;
            --ross-radius: 16px;
            --ross-radius-lg: 24px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--ross-bg);
            color: var(--ross-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        h1, h2, h3, .font-serif, .navbar-brand {
            font-family: 'Playfair Display', Georgia, serif;
        }

        /* Top Announcement Bar */
        .top-announcement {
            background: linear-gradient(90deg, var(--ross-primary-dark) 0%, var(--ross-primary) 100%);
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.825rem;
            padding: 7px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .top-announcement a {
            color: var(--ross-gold);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .top-announcement a:hover {
            color: #FFFFFF;
        }

        /* Main Navbar */
        .navbar-ross {
            background: linear-gradient(135deg, var(--ross-primary) 0%, #680E10 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-bottom: 3px solid var(--ross-gold);
            padding: 12px 0;
            transition: all 0.3s ease;
        }
        .navbar-brand {
            font-weight: 700;
            color: #FFFFFF !important;
            letter-spacing: 0.5px;
            transition: transform 0.2s ease;
        }
        .navbar-brand:hover {
            transform: scale(1.02);
        }
        .brand-logo-img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid var(--ross-gold);
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .navbar-ross .nav-link {
            color: rgba(255, 255, 255, 0.88) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 8px 16px !important;
            border-radius: 24px;
            transition: all 0.25s ease;
        }
        .navbar-ross .nav-link:hover {
            color: var(--ross-gold) !important;
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-1px);
        }
        .navbar-ross .nav-link.active {
            color: var(--ross-gold) !important;
            background: rgba(255, 255, 255, 0.12);
            font-weight: 600;
        }

        .cart-nav-btn {
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #FFFFFF !important;
            padding: 8px 18px !important;
            border-radius: 30px;
        }
        .cart-nav-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: var(--ross-gold);
            color: var(--ross-gold) !important;
        }
        .cart-nav-badge {
            font-size: 0.72rem;
            font-weight: 700;
            background-color: var(--ross-orange) !important;
            color: white !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            animation: pulse-badge 2s infinite;
        }
        @keyframes pulse-badge {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }

        /* Buttons */
        .btn-ross-primary {
            background: linear-gradient(135deg, var(--ross-orange) 0%, var(--ross-orange-hover) 100%);
            color: #FFFFFF !important;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            padding: 10px 24px;
            box-shadow: 0 4px 14px rgba(255, 87, 34, 0.35);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-ross-primary:hover {
            background: linear-gradient(135deg, #FF6E40 0%, var(--ross-orange) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 87, 34, 0.45);
            color: #FFFFFF !important;
        }
        .btn-ross-primary:active {
            transform: translateY(0);
        }

        .btn-ross-secondary {
            background: linear-gradient(135deg, var(--ross-primary) 0%, var(--ross-primary-dark) 100%);
            color: #FFFFFF !important;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            padding: 10px 24px;
            box-shadow: 0 4px 14px rgba(122, 17, 19, 0.3);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-ross-secondary:hover {
            background: linear-gradient(135deg, var(--ross-primary-light) 0%, var(--ross-primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(122, 17, 19, 0.4);
            color: var(--ross-gold) !important;
        }

        .btn-ross-gold {
            background: linear-gradient(135deg, var(--ross-gold) 0%, var(--ross-gold-dark) 100%);
            color: var(--ross-primary-dark) !important;
            border: none;
            border-radius: 30px;
            font-weight: 700;
            padding: 10px 24px;
            box-shadow: 0 4px 14px rgba(255, 179, 0, 0.35);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-ross-gold:hover {
            background: linear-gradient(135deg, #FFCA28 0%, var(--ross-gold) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 179, 0, 0.45);
        }

        .btn-ross-outline {
            background: transparent;
            color: var(--ross-primary) !important;
            border: 2px solid var(--ross-primary);
            border-radius: 30px;
            font-weight: 600;
            padding: 8px 22px;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-ross-outline:hover {
            background: var(--ross-primary);
            color: #FFFFFF !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(122, 17, 19, 0.25);
        }

        .btn-ross-outline-white {
            background: transparent;
            color: #FFFFFF !important;
            border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 30px;
            font-weight: 600;
            padding: 8px 22px;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-ross-outline-white:hover {
            background: #FFFFFF;
            color: var(--ross-primary) !important;
            border-color: #FFFFFF;
            transform: translateY(-2px);
        }

        /* Standard Cards */
        .card-ross {
            background: var(--ross-surface);
            border-radius: var(--ross-radius);
            border: 1px solid var(--ross-border);
            box-shadow: var(--ross-shadow-sm);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
        }
        .card-ross:hover {
            transform: translateY(-5px);
            box-shadow: var(--ross-shadow);
            border-color: rgba(255, 87, 34, 0.3);
        }

        /* Section Headings */
        .section-header {
            position: relative;
            margin-bottom: 2.5rem;
        }
        .section-header .section-subtitle {
            color: var(--ross-orange);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 2px;
            margin-bottom: 0.4rem;
            display: block;
        }
        .section-header .section-title {
            color: var(--ross-primary);
            font-weight: 700;
            font-size: 2.25rem;
            margin-bottom: 0.5rem;
        }
        .section-header .section-divider {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--ross-orange) 0%, var(--ross-gold) 100%);
            border-radius: 2px;
            margin: 0 auto;
        }

        /* Form Inputs */
        .form-control, .form-select {
            border-radius: 12px;
            border: 1.5px solid #D8D2C6;
            padding: 10px 16px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background-color: #FFFFFF;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--ross-orange);
            box-shadow: 0 0 0 4px rgba(255, 87, 34, 0.15);
            outline: none;
        }
        .form-label {
            font-weight: 600;
            color: #4A403A;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }

        /* Dropdowns */
        .dropdown-menu-ross {
            border-radius: var(--ross-radius-sm);
            border: 1px solid var(--ross-border);
            box-shadow: var(--ross-shadow);
            padding: 8px;
        }
        .dropdown-menu-ross .dropdown-item {
            border-radius: 8px;
            padding: 9px 16px;
            font-weight: 500;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dropdown-menu-ross .dropdown-item:hover {
            background-color: var(--ross-orange-light);
            color: var(--ross-orange);
        }

        /* Footer */
        .footer-ross {
            background: linear-gradient(135deg, var(--ross-primary-dark) 0%, var(--ross-primary) 100%);
            color: rgba(255, 255, 255, 0.85);
            border-top: 5px solid var(--ross-orange);
            margin-top: auto;
            position: relative;
        }
        .footer-ross h5 {
            color: #FFFFFF;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1.25rem;
            position: relative;
            padding-bottom: 10px;
        }
        .footer-ross h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 35px;
            height: 2px;
            background-color: var(--ross-gold);
        }
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }
        .footer-links a:hover {
            color: var(--ross-gold);
            transform: translateX(4px);
        }
        .footer-social-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.25s ease;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .footer-social-btn:hover {
            background: var(--ross-orange);
            color: #FFFFFF;
            transform: translateY(-3px);
            border-color: var(--ross-orange);
        }
        .footer-bottom {
            background: rgba(0, 0, 0, 0.25);
            padding: 16px 0;
            font-size: 0.85rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Badge Custom */
        .badge-ross-primary {
            background-color: var(--ross-primary);
            color: #FFFFFF;
        }
        .badge-ross-orange {
            background-color: var(--ross-orange-light);
            color: var(--ross-orange);
            border: 1px solid rgba(255, 87, 34, 0.25);
        }
        .badge-ross-gold {
            background-color: var(--ross-gold-light);
            color: #8C5B00;
            border: 1px solid rgba(255, 179, 0, 0.3);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Announcement Bar -->
    <div class="top-announcement d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-clock-fill text-warning me-1"></i> Lun - Dom: 08:00 - 20:00</span>
                <span class="opacity-50">|</span>
                <span><i class="bi bi-geo-alt-fill text-warning me-1"></i> Av. Principal #123</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="tel:+59170000000"><i class="bi bi-telephone-fill me-1"></i> +591 70000000</a>
                <span class="opacity-50">|</span>
                <a href="{{ route('portafolio') }}"><i class="bi bi-person-badge-fill me-1"></i> Portafolio Dev</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-ross sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Doña Ross Logo" class="brand-logo-img">
                <div class="d-flex flex-column">
                    <span class="fs-4 lh-1">Doña Ross</span>
                    <span class="small text-warning fw-normal" style="font-size: 0.7rem; letter-spacing: 1px; font-family: 'Plus Jakarta Sans', sans-serif;">RESTAURANTE TRADICIONAL</span>
                </div>
            </a>

            <button class="navbar-toggler border-0 text-white shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-1 text-warning"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('catalogo*') ? 'active' : '' }}" href="{{ route('catalogo') }}">
                            <i class="bi bi-egg-fried me-1"></i> Catálogo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('promociones*') ? 'active' : '' }}" href="{{ route('promociones') }}">
                            <i class="bi bi-tag-fill me-1"></i> Promociones
                        </a>
                    </li>

                    @auth
                        @if(auth()->user()->isCliente())
                            <li class="nav-item">
                                <a class="nav-link cart-nav-btn {{ request()->routeIs('cliente.carrito') ? 'active' : '' }}" href="{{ route('cliente.carrito') }}">
                                    <i class="bi bi-cart3 me-1"></i> Carrito
                                    @php $cartCount = array_sum(session('carrito', [])); @endphp
                                    @if($cartCount > 0)
                                        <span class="badge rounded-pill cart-nav-badge ms-1">{{ $cartCount }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle fs-5 text-warning"></i>
                                    <span>{{ Str::limit(auth()->user()->name, 15) }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-ross shadow border-0">
                                    <li><a class="dropdown-item" href="{{ route('cliente.dashboard') }}"><i class="bi bi-speedometer2 text-primary"></i> Mi Panel</a></li>
                                    <li><a class="dropdown-item" href="{{ route('cliente.pedidos') }}"><i class="bi bi-bag-check text-success"></i> Mis Pedidos</a></li>
                                    <li><a class="dropdown-item" href="{{ route('cliente.perfil') }}"><i class="bi bi-gear text-secondary"></i> Mi Perfil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right text-danger"></i> Cerrar Sesión
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @elseif(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="btn btn-ross-gold btn-sm px-3 ms-2" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-shield-lock-fill me-1"></i> Panel Admin
                                </a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link p-2 border-0 text-white opacity-75" title="Salir">
                                        <i class="bi bi-box-arrow-right fs-5"></i>
                                    </button>
                                </form>
                            </li>
                        @elseif(auth()->user()->isPersonal())
                            <li class="nav-item">
                                <a class="btn btn-ross-gold btn-sm px-3 ms-2" href="{{ route('personal.dashboard') }}">
                                    <i class="bi bi-person-badge-fill me-1"></i> Panel Personal
                                </a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link p-2 border-0 text-white opacity-75" title="Salir">
                                        <i class="bi bi-box-arrow-right fs-5"></i>
                                    </button>
                                </form>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="btn btn-ross-primary dropdown-toggle px-4" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-lock me-1"></i> Acceso
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-ross shadow border-0">
                                <li><a class="dropdown-item" href="{{ route('login.cliente') }}"><i class="bi bi-person-check text-primary"></i> Iniciar Sesión Cliente</a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}"><i class="bi bi-person-plus text-success"></i> Crear Cuenta Nueva</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger fw-bold" href="{{ route('login.admin') }}"><i class="bi bi-shield-lock text-danger"></i> Personal / Admin</a></li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            @include('partials.alerts')
        </div>
        @yield('content')
    </main>

    <!-- Professional Footer -->
    <footer class="footer-ross pt-5">
        <div class="container">
            <div class="row g-4 pb-4">
                <!-- Brand Col -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="brand-logo-img" style="width: 54px; height: 54px;">
                        <div>
                            <h4 class="text-white fw-bold mb-0 font-serif">Doña Ross</h4>
                            <span class="text-warning small">El auténtico sabor casero</span>
                        </div>
                    </div>
                    <p class="text-white-50 small pe-lg-3">
                        Dedicados a deleitar paladares con los mejores platillos tradicionales, preparados con recetas familiares, ingredientes frescos y la calidez de siempre.
                    </p>
                    <div class="d-flex gap-2 pt-2">
                        <a href="#" class="footer-social-btn" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="footer-social-btn" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="https://wa.me/59170000000" target="_blank" class="footer-social-btn" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        <a href="{{ route('portafolio') }}" class="footer-social-btn" title="Portafolio"><i class="bi bi-code-slash"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h5>Navegación</h5>
                    <div class="footer-links">
                        <a href="{{ route('home') }}"><i class="bi bi-chevron-right text-warning"></i> Inicio</a>
                        <a href="{{ route('catalogo') }}"><i class="bi bi-chevron-right text-warning"></i> Menú y Catálogo</a>
                        <a href="{{ route('promociones') }}"><i class="bi bi-chevron-right text-warning"></i> Promociones</a>
                        <a href="{{ route('portafolio') }}"><i class="bi bi-chevron-right text-warning"></i> Portafolio Web</a>
                    </div>
                </div>

                <!-- Contact & Info -->
                <div class="col-lg-3 col-md-6">
                    <h5>Contacto y Delivery</h5>
                    <div class="footer-links">
                        <span class="d-flex align-items-start gap-2 mb-2 text-white-50 small">
                            <i class="bi bi-geo-alt-fill text-warning fs-6 mt-1"></i>
                            <span>Av. Principal #123, Zona Central</span>
                        </span>
                        <a href="tel:+59170000000">
                            <i class="bi bi-telephone-fill text-warning"></i> +591 70000000
                        </a>
                        <a href="mailto:contacto@donaross.com">
                            <i class="bi bi-envelope-fill text-warning"></i> contacto@donaross.com
                        </a>
                        <span class="d-flex align-items-center gap-2 mt-2 text-warning small fw-bold">
                            <i class="bi bi-bicycle fs-5"></i> ¡Delivery disponible en toda la zona!
                        </span>
                    </div>
                </div>

                <!-- Horarios -->
                <div class="col-lg-3 col-md-6">
                    <h5>Horarios de Atención</h5>
                    <ul class="list-unstyled text-white-50 small mb-3">
                        <li class="d-flex justify-content-between py-1 border-bottom border-secondary border-opacity-25">
                            <span>Lunes - Viernes:</span>
                            <strong class="text-white">08:00 - 20:00</strong>
                        </li>
                        <li class="d-flex justify-content-between py-1 border-bottom border-secondary border-opacity-25">
                            <span>Sábados:</span>
                            <strong class="text-white">09:00 - 21:00</strong>
                        </li>
                        <li class="d-flex justify-content-between py-1">
                            <span>Domingos:</span>
                            <strong class="text-white">09:00 - 18:00</strong>
                        </li>
                    </ul>
                    <a href="{{ route('catalogo') }}" class="btn btn-ross-gold btn-sm w-100 py-2">
                        <i class="bi bi-bag-plus-fill me-1"></i> ¡Haz tu pedido ahora!
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <span class="text-white-50">&copy; {{ date('Y') }} Restaurante Doña Ross. Todos los derechos reservados.</span>
                <span class="text-white-50 small">Desarrollado con <i class="bi bi-heart-fill text-danger mx-1"></i> para la mejor experiencia gastronómica.</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

