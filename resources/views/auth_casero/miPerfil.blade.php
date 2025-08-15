@extends('base')

@section('title', 'Probando Extensión')

@section('extra_stylesheets')

@endsection

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Mi Perfil</h2>
        
        <div class="row">
            <!-- Card: Datos del Usuario -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-user-circle me-2"></i> Datos del Usuario</h5>
                        <p><strong>Username:</strong>{{ $usuario->username }}</p>
                        <p><strong>Email:</strong>{{ $usuario->email }}</p>
                        <p><strong>Rol:</strong>{{ $usuario->rela_rol }}</p>
                        <hr>
                        <a href="/perfil/cambiar-contraseña" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-key me-1"></i> Cambiar contraseña
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card: Datos Personales -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-id-card me-2"></i> Datos Personales</h5>
                        <p><strong>Nombre:</strong> {{ $nombre }}</p>
                        <p><strong>Apellido:</strong> {{ $apellido }}</p>
                        <p><strong>Tipo de Documento:</strong> {{ $tipo_documento }}</p>
                        <p><strong>Número de Documento:</strong> {{ $numero_documento }}</p>
                        <p><strong>Sexo:</strong> {{ $sexo }}</p>
                        <p><strong>Fecha de Nacimiento:</strong> {{ $fecha_nacimiento }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra_js')

@endsection
