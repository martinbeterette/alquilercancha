<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link                   href="{{ asset("vendor/css/bootstrap_mdb.min.css") }}" rel="stylesheet" />
    <link rel="stylesheet"  href="{{ asset("vendor/fontawesome/css/all.min.css") }}">
    {{-- Estilos personalizados para ir a un css a parte --}}
    <style>
        .text-django {
            color: #44B78B !important;
        }
    </style>
    @vite('resources/css/app.css')
    @livewireStyles
    @fluxAppearance
    @yield('extra_stylesheets')
</head>
<body class="bg-light">
  {{-- SNACKBAR --}}
    @include('partials.snackbar')

    <div class="d-flex">

        <!-- Botón hamburguesa para móviles -->
        <button class="btn btn-primary d-md-none m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar Desktop -->
        <aside class="bg-light text-dark p-3 d-none d-md-block" style="width: 250px; height: 100vh; position: fixed;">
            @include('partials.sidebar_bootstrap')
        </aside>

        <!-- Sidebar Mobile (Offcanvas) -->
        <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mobileSidebarLabel">Mi Sistema</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
            </div>
            <div class="offcanvas-body p-0">
                @include('partials.sidebar_bootstrap')
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="flex-fill" style="padding: 20px; margin-left: 250px;">
            {{-- Header --}}
            <main class="container mt-4">
                {{ $slot ?? '' }} {{-- Aca va el contenido de Beterette --}}
                @yield('content') {{-- Aca va el contenido de Coppa --}}
            </main>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-light text-center py-3 mt-4">
        @include('partials.footer')
    </footer>

    {{-- Responsive: quitar margin-left en móviles --}}
    <style>
        @media (max-width: 767.98px) {
            div.flex-fill {
                margin-left: 0 !important;
            }
        }
    </style>
    <script src="{{ asset("vendor/libs/jquery.min.js") }}"></script>
    <script src="{{ asset("vendor/libs/bootstrap_popper.min.js") }}"></script>
    <script src="{{ asset("vendor/libs/bootstrap_mdb_ui_kit.min.js") }}"></script>
    <script src="{{ asset("vendor/libs/axios.min.js") }}"></script>


    {{-- Aquí irían los JS particulares de la página --}}
    @yield('extra_js')
    @fluxScripts
    @livewireScripts
</body>
</html>