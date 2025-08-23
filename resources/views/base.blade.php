<!DOCTYPE html>
<html lang="en">
<head>
  {{--   @if (!session('usuario'))
        <script>
            window.location.href = "{{ url('/login-casero') }}";
        </script>
    @endif --}}
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
    {{-- SNACKBAR, HAY QUE MANDARLO A COMPONENTS --}}
    @if ($errors->any())
        <div 
            id="snackbar-errors" 
            class="position-fixed bottom-0 end-0 m-3 alert alert-danger alert-dismissible fade show shadow-lg rounded-3"
            style="z-index: 1050; min-width: 300px;"
            role="alert"
        >
            <h5 class="alert-heading mb-2">Error</h5>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
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