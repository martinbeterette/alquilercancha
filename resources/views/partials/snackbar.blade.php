 {{-- Errores de validación --}}
@if ($errors->any())
    <div 
        id="snackbar-errors" 
        class="position-fixed top-0 start-50 translate-middle-x mt-3 alert alert-danger alert-dismissible fade show shadow-lg rounded-3"
        style="z-index: 1050; min-width: 300px;"
        role="alert"
    >
        <h5 class="alert-heading mb-2">Error</h5>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" onclick="$('#snackbar-errors').hide()" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

@if (session('success'))
    <div 
        id="snackbar-success" 
        class="position-fixed top-0 start-50 translate-middle-x mt-3 alert alert-success alert-dismissible fade show shadow-lg rounded-3"
        style="z-index: 1050; min-width: 300px;"
        role="alert"
    >
        <h5 class="alert-heading mb-2">Éxito</h5>
        <p class="mb-0 ps-1">{{ session('success') }}</p>
        <button type="button" onclick="$('#snackbar-success').hide()" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>

    <script>
        setTimeout(() => {
            $('#snackbar-success')?.fadeOut(500);
        }, 3000); // 3 segundos
    </script>
@endif