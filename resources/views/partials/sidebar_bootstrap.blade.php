<div class="d-flex flex-column align-items-start h-100">
    <!-- Logo / Título del sistema -->
    <div class="text-center w-100 mb-4">
        <h4 class="text-white">Mi Sistema</h4>
    </div>

    <!-- Menú de navegación -->
    <ul class="nav flex-column w-100">
        <li class="nav-item">
            <a href="/home" class="nav-link text-white">
                <i class="fas fa-home me-2"></i> Inicio
            </a>
        </li>
        <li class="nav-item">
            <a href="/usuarios" class="nav-link text-white">
                <i class="fas fa-users me-2"></i> Usuarios
            </a>
        </li>
        <li class="nav-item">
            <a href="/sucursal" class="nav-link text-white">
                <i class="fas fa-calendar-alt me-2"></i> Sucursales
            </a>
        </li>
        <li class="nav-item">
            <a href="/tablas-maestras" class="nav-link text-white">
                <i class="fas fa-calendar-alt me-2"></i> Tablas maestras
            </a>
        </li>
        <li class="nav-item">
            <a href="/reportes" class="nav-link text-white">
                <i class="fas fa-chart-line me-2"></i> Reportes
            </a>
        </li>
        <li class="nav-item">
            <a href="/configuracion" class="nav-link text-white">
                <i class="fas fa-cogs me-2"></i> Configuración
            </a>
        </li>
    </ul>

    <!-- Usuario con menú desplegable -->
    <div class="dropdown dropup w-100 mt-auto text-start px-3 mb-3">
        <button class="btn btn-outline-light w-100 d-flex align-items-center justify-content-between" type="button" id="dropdownUserMenu" data-mdb-toggle="dropdown" aria-expanded="false">
            <div>
                <i class="fas fa-user-circle me-2"></i> {{ session('usuario')->username ?? '-' }}
            </div>
            <i class="fas fa-chevron-up"></i>
        </button>
        <ul class="dropdown-menu w-100" aria-labelledby="dropdownUserMenu">
            <li>
                <a class="dropdown-item" href="/mi-perfil">
                    <i class="fas fa-id-badge me-2"></i> Mi Perfil
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="/configuracion">
                    <i class="fas fa-sliders-h me-2"></i> Configuración
                </a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item text-danger" href="{{ route('logout.casero') }}">
                    <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
                </a>
            </li>
        </ul>
    </div>
</div>

