<!DOCTYPE html>
<html lang="en">
<head>
    @if (!session('usuario'))
        <script>
            window.location.href = "{{ url('/login-casero') }}";
        </script>
    @endif
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap MDB CSS -->
    <link href="{{ asset("vendor/css/bootstrap_mdb.min.css") }}" rel="stylesheet" />
    {{-- font awesome --}}
    <link rel="stylesheet" href="{{ asset("vendor/fontawesome/css/all.min.css") }}">
    {{-- Aquí irían los CSS y JS particulares de la página --}}
    @yield('extra_stylesheets')
</head>
<body>
    <div class="d-flex">
        {{-- Barra de navegación Sidebar --}}
        
        <aside class="bg-dark text-white p-3" style="width: 250px; height: 100vh; position: fixed;">
            @include('partials.sidebar_bootstrap')
        </aside>
       

        {{-- Contenido principal --}}
        <div class="flex-grow-1" style="margin-left: 250px; padding: 20px;">
            {{-- Header --}}
            <main class="container-mt-4">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Footer --}}

    <footer class="bg-light text-center py-3 mt-4">
        @include('partials.footer')
    </footer>


    <!-- Bootstrap MDB JS -->
    <script src="{{ asset("vendor/libs/bootstrap_mdb_ui_kit.min.js") }}"></script>
    <script src="{{ asset("vendor/libs/bootstrap_popper.min.js") }}"></script>
    <script src="{{ asset("vendor/libs/jquery.min.js") }}"></script>
    <!-- AXIOS -->
    <script src="{{ asset("vendor/libs/axios.min.js") }}"></script>

    <!-- VUE -->
    <script src="{{ asset("vendor/libs/vue.min.js") }}"></script>
    {{-- Aquí irían los JS particulares de la página --}}
    @yield('extra_js')
</body>
</html>