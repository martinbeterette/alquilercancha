@extends('base')

@section('title', 'Inicio')

@section('extra_stylesheets')
    <style>
        .welcome-card {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            color: white;
        }
    </style>
@endsection

@section('content')
<div class="container py-5">

    <!-- Banner de bienvenida -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 p-5 text-center bg-light">
                <h1 class="fw-bold">¡Bienvenido a Mi Sistema!</h1>
                <p class="lead text-muted">
                    {{ auth()->user()->name ?? 'Usuario' }}, este es tu panel principal.
                </p>
                <p class="text-secondary mb-0">
                    Estamos preparando nuevas funcionalidades para que gestiones todo desde aquí 💛
                </p>
            </div>
        </div>
    </div>

    <!-- Próximamente -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 p-4 bg-light">
                <h4 class="mb-3 fw-bold">Próximamente:</h4>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-store text-primary me-2"></i>
                        Gestión de Sucursales
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-basketball-ball text-success me-2"></i>
                        Gestión de Canchas
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-tags text-warning me-2"></i>
                        Gestión de Tarifas
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-id-card text-info me-2"></i>
                        Gestión de Socios y Membresías
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-calendar-alt text-danger me-2"></i>
                        Reservas de Canchas
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>

@endsection

@section('extra_js')
    <script>
        console.log("Script específico de la página de inicio");
    </script>
@endsection
