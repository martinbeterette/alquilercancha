@extends('base')

@section('title', 'Administración')

@section('extra_stylesheets')
@endsection

@section('content')

<div class="container py-4">
    <h2 class="mb-4 fw-bold">Panel de Administración</h2>

    <div class="row g-4">
        <!-- Roles -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <i class="fas fa-user-shield fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Roles</h5>
                    <p class="card-text">Gestiona los distintos roles del sistema.</p>
                    <a href="{{ url('/roles') }}" class="btn btn-primary mt-auto">Ir a Roles</a>
                </div>
            </div>
        </div>

        <!-- Gestión de Usuarios -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <i class="fas fa-users fa-3x mb-3 text-success"></i>
                    <h5 class="card-title">Gestión de Usuarios</h5>
                    <p class="card-text">Administra usuarios, accesos y permisos.</p>
                    <a href="{{ url('/usuarios') }}" class="btn btn-success mt-auto">Ir a Usuarios</a>
                </div>
            </div>
        </div>

        <!-- Módulos -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <i class="fas fa-cubes fa-3x mb-3 text-warning"></i>
                    <h5 class="card-title">Módulos</h5>
                    <p class="card-text">Configura y organiza los módulos disponibles.</p>
                    <a href="{{ url('/modulos') }}" class="btn btn-warning mt-auto">Ir a Módulos</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_js')
@endsection
