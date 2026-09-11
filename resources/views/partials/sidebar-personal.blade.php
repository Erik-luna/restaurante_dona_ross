<nav class="nav flex-column">
    <div class="sidebar-section-title">Principal</div>
    <a href="{{ route('personal.dashboard') }}" class="nav-link {{ request()->routeIs('personal.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="sidebar-section-title">Gestión de Ventas</div>
    <a href="{{ route('personal.ventas.index') }}" class="nav-link {{ request()->routeIs('personal.ventas.*') ? 'active' : '' }}">
        <i class="bi bi-receipt-cutoff"></i> Ventas
    </a>
    <a href="{{ route('personal.clientes.index') }}" class="nav-link {{ request()->routeIs('personal.clientes.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Clientes
    </a>
</nav>

