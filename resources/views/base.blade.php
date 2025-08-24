<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link                   href="{{ asset("vendor/css/bootstrap_mdb.min.css") }}" rel="stylesheet" />
    <link rel="stylesheet"  href="{{ asset("vendor/fontawesome/css/all.min.css") }}">
    @yield('extra_stylesheets')
</head>
<body>
    {{-- SNACKBAR, HAY QUE MANDARLO A COMPONENTS --}}
    @include('partials.snackbar')
    <div class="d-flex">
        
        <aside class="bg-light text-white p-3" style="width: 250px; height: 100vh; position: fixed;">
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


    <script src="{{ asset("vendor/libs/jquery.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset("vendor/libs/bootstrap_popper.min.js") }}"></script> --}}
    <script src="{{ asset("vendor/libs/bootstrap_mdb_ui_kit.min.js") }}"></script>
    <script src="{{ asset("vendor/libs/axios.min.js") }}"></script>

    <!-- VUE -->
    {{-- <script src="{{ asset("vendor/libs/vue.min.js") }}"></script> --}}
    {{-- Aquí irían los JS particulares de la página --}}
    @yield('extra_js')
</body>
</html>