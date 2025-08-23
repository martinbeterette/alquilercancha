<div class="dropdown">
    <!-- Botón que dispara el dropdown -->
    <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user-circle me-2"></i>
        {{ Auth::user()->name }}
    </button>

    <!-- Contenido del dropdown -->
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <!-- Profile -->
        <li>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="fas fa-user me-2"></i>Profile
            </a>
        </li>

        <!-- Logout -->
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="fas fa-sign-out-alt me-2"></i>Log Out
                </button>
            </form>
        </li>
    </ul>
</div>
