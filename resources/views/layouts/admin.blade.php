<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doña Ross - @yield('title', 'Panel de Control')</title>
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
            --ross-primary-dark: #52090C;
            --ross-primary-light: #9B1C1F;
            --ross-orange: #FF5722;
            --ross-orange-hover: #E64A19;
            --ross-orange-light: #FFEDE6;
            --ross-gold: #FFB300;
            --ross-gold-dark: #E59800;
            --ross-gold-light: #FFF8E1;
            --ross-bg: #F4F6F9;
            --ross-surface: #FFFFFF;
            --ross-text: #1E293B;
            --ross-text-muted: #64748B;
            --ross-border: #E2E8F0;
            --ross-shadow-sm: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03);
            --ross-shadow: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
            --ross-shadow-lg: 0 10px 25px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.04);
            --ross-radius-sm: 8px;
            --ross-radius: 14px;
            --ross-radius-lg: 20px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--ross-bg);
            color: var(--ross-text);
            min-height: 100vh;
        }

        h1, h2, h3, h4, .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        /* Admin Topbar */
        .admin-topbar {
            background: #FFFFFF;
            border-bottom: 2px solid var(--ross-border);
            padding: 10px 24px;
            box-shadow: var(--ross-shadow-sm);
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        .admin-brand-logo {
            width: 36px;
            height: 36px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid var(--ross-gold);
        }

        /* Sidebar */
        .admin-sidebar {
            background: linear-gradient(180deg, var(--ross-primary) 0%, var(--ross-primary-dark) 100%);
            min-height: calc(100vh - 62px);
            padding: 20px 14px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.08);
        }
        .sidebar-section-title {
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 10px 14px 4px 14px;
            margin-top: 10px;
        }
        .admin-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.82) !important;
            font-weight: 500;
            font-size: 0.92rem;
            padding: 10px 16px;
            border-radius: 10px;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
        }
        .admin-sidebar .nav-link i {
            font-size: 1.15rem;
            opacity: 0.9;
            transition: transform 0.2s ease;
        }
        .admin-sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #FFFFFF !important;
            transform: translateX(3px);
        }
        .admin-sidebar .nav-link:hover i {
            transform: scale(1.15);
        }
        .admin-sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(255, 179, 0, 0.25) 0%, rgba(255, 87, 34, 0.15) 100%);
            color: var(--ross-gold) !important;
            font-weight: 600;
            border-left: 4px solid var(--ross-gold);
        }
        .admin-sidebar .nav-link.active i {
            color: var(--ross-gold);
        }

        /* Stat Card */
        .card-stat {
            background: #FFFFFF;
            border-radius: var(--ross-radius);
            border: 1px solid var(--ross-border);
            box-shadow: var(--ross-shadow-sm);
            padding: 20px;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .card-stat:hover {
            transform: translateY(-4px);
            box-shadow: var(--ross-shadow);
            border-color: rgba(255, 87, 34, 0.3);
        }
        .card-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Admin Action Buttons */
        .btn-ross-primary {
            background: linear-gradient(135deg, var(--ross-orange) 0%, var(--ross-orange-hover) 100%);
            color: #FFFFFF !important;
            border: none;
            border-radius: 24px;
            font-weight: 600;
            padding: 8px 20px;
            box-shadow: 0 2px 8px rgba(255, 87, 34, 0.25);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-ross-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(255, 87, 34, 0.35);
        }

        .btn-ross-secondary {
            background: var(--ross-primary);
            color: #FFFFFF !important;
            border: none;
            border-radius: 24px;
            font-weight: 600;
            padding: 8px 20px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-ross-secondary:hover {
            background: var(--ross-primary-dark);
            color: var(--ross-gold) !important;
            transform: translateY(-1px);
        }

        /* Admin Table Styles */
        .table-card {
            background: #FFFFFF;
            border-radius: var(--ross-radius);
            border: 1px solid var(--ross-border);
            box-shadow: var(--ross-shadow-sm);
            overflow: hidden;
        }
        .table-card table {
            margin-bottom: 0;
        }
        .table-card table thead th {
            background-color: #F8FAFC;
            color: #475569;
            font-weight: 600;
            font-size: 0.825rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border-bottom: 1px solid var(--ross-border);
        }
        .table-card table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            color: #334155;
            font-size: 0.925rem;
            border-bottom: 1px solid #F1F5F9;
        }
        .table-card table tbody tr:hover td {
            background-color: #FCFAF7;
        }

        /* Form Controls */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #CBD5E1;
            padding: 9px 14px;
            font-size: 0.925rem;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--ross-orange);
            box-shadow: 0 0 0 3px rgba(255, 87, 34, 0.15);
        }
        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.875rem;
            margin-bottom: 0.35rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Topbar -->
    <nav class="admin-topbar">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="admin-brand-logo">
                    <div>
                        <span class="fw-bold font-serif fs-5" style="color: var(--ross-primary);">Doña Ross</span>
                        <span class="badge bg-secondary-subtle text-dark ms-2 fw-semibold" style="font-size: 0.75rem;">@yield('panel-title', 'Panel')</span>
                    </div>
                </a>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2 px-3 py-1 bg-light rounded-pill border">
                    <i class="bi bi-person-circle fs-5" style="color: var(--ross-primary);"></i>
                    <span class="fw-semibold small text-dark">{{ auth()->user()->name }}</span>
                    <span class="badge rounded-pill text-uppercase px-2" style="background: var(--ross-gold); color: #5A0B0D; font-size: 0.68rem;">
                        {{ auth()->user()->role }}
                    </span>
                </div>

                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3" target="_blank" title="Abrir sitio web público">
                    <i class="bi bi-box-arrow-up-right me-1"></i> <span class="d-none d-md-inline">Ver Sitio</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" title="Cerrar sesión">
                        <i class="bi bi-box-arrow-right me-1"></i> <span class="d-none d-md-inline">Salir</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar Col -->
            <div class="col-md-3 col-lg-2 admin-sidebar">
                @yield('sidebar')
            </div>

            <!-- Content Col -->
            <div class="col-md-9 col-lg-10 p-4 p-md-5">
                @include('partials.alerts')
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

