<div class="d-flex flex-column align-items-start h-100 bg-light" style="width: 250px; padding: 1rem;">

    <!-- Logo / Título del sistema -->
    <div class="text-center w-100 mb-4">
        <h4 class="text-dark fw-bold">Mi Sistema</h4>
    </div>

    <!-- Menú de navegación -->
    <ul class="nav flex-column w-100">
        <li class="nav-item mb-1">
            <a href="/home" class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center hover-bg-light">
                <i class="fas fa-home me-2"></i> Inicio
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/usuarios" class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center hover-bg-light">
                <i class="fas fa-users me-2"></i> Usuarios
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/sucursal" class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center hover-bg-light">
                <i class="fas fa-calendar-alt me-2"></i> Sucursales
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/tablas-maestras" class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center hover-bg-light">
                <i class="fas fa-table me-2"></i> Tablas maestras
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/reportes" class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center hover-bg-light">
                <i class="fas fa-chart-line me-2"></i> Reportes
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/configuracion" class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center hover-bg-light">
                <i class="fas fa-cogs me-2"></i> Configuración
            </a>
        </li>
    </ul>

    <!-- Usuario con menú desplegable -->
    @auth
    <div class="dropdown dropup w-100 mt-auto text-start px-3 mb-3">
        <button class="btn btn-light w-100 d-flex align-items-center justify-content-between border rounded" type="button" id="dropdownUserMenu" data-mdb-toggle="dropdown" aria-expanded="false">
            <div class="text-dark">
                <i class="fas fa-user-circle me-2"></i> {{ Auth::user()->name }}
            </div>
            <i class="fas fa-chevron-up text-dark"></i>
        </button>
        <ul class="dropdown-menu w-100 shadow-sm" aria-labelledby="dropdownUserMenu">
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                    <i class="fas fa-id-badge me-2"></i> Mi Perfil
                </a>
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="/configuracion">
                    <i class="fas fa-sliders-h me-2"></i> Configuración
                </a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
                    </button>
                </form>
            </li>
        </ul>
    </div>
    @endauth
</div>
