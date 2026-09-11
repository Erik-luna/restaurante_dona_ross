<nav class="nav flex-column">
    <div class="sidebar-section-title">Principal</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="sidebar-section-title">Catálogo & Ventas</div>
    <a href="{{ route('admin.productos.index') }}" class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
        <i class="bi bi-egg-fried"></i> Productos
    </a>
    <a href="{{ route('admin.pedidos.index') }}" class="nav-link {{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}">
        <i class="bi bi-cart-check"></i> Pedidos Online
    </a>
    <a href="{{ route('admin.ventas.index') }}" class="nav-link {{ request()->routeIs('admin.ventas.*') ? 'active' : '' }}">
        <i class="bi bi-receipt-cutoff"></i> Ventas Locales
    </a>
    <a href="{{ route('admin.promociones.index') }}" class="nav-link {{ request()->routeIs('admin.promociones.*') ? 'active' : '' }}">
        <i class="bi bi-tag-fill"></i> Promociones
    </a>
    <a href="{{ route('admin.stock.index') }}" class="nav-link {{ request()->routeIs('admin.stock.*') ? 'active' : '' }}">
        <i class="bi bi-boxes"></i> Control de Stock
    </a>

    <div class="sidebar-section-title">Usuarios & Config</div>
    <a href="{{ route('admin.personal.index') }}" class="nav-link {{ request()->routeIs('admin.personal.*') ? 'active' : '' }}">
        <i class="bi bi-person-badge"></i> Personal
    </a>
    <a href="{{ route('admin.clientes.index') }}" class="nav-link {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Clientes
    </a>
    <a href="{{ route('admin.portafolio.index') }}" class="nav-link {{ request()->routeIs('admin.portafolio.*') ? 'active' : '' }}">
        <i class="bi bi-briefcase"></i> Portafolio
    </a>
    <a href="{{ route('admin.horarios') }}" class="nav-link {{ request()->routeIs('admin.horarios') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Horarios
    </a>
</nav>

