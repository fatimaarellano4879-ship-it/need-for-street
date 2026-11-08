
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    {{-- Marca del sistema --}}
    <div class="app-brand demo">
        <a href="{{ route('inicio') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2">
                NEED FOR STREET
            </span>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>
    <div class="menu-inner-shadow"></div>

    {{-- Navegación principal --}}
    <ul class="menu-inner py-1">

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Principal</span>
        </li>

        <li class="menu-item {{ request()->routeIs('inicio') ? 'active' : '' }}">
            <a href="{{ route('inicio') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Inicio</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Gestión de productos</span>
        </li>

        <li class="menu-item {{ request()->routeIs('productos.index') ? 'active' : '' }}">
            <a href="{{ route('productos.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div>Catálogo de productos</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('productos.create') ? 'active' : '' }}">
            <a href="{{ route('productos.create') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                <div>Registrar producto</div>
            </a>
        </li>

    </ul>
</aside>
