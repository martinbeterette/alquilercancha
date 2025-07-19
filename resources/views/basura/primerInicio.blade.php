@extends('base')

@section('title', 'Bienvenido')

@section('extra_stylesheets')
@endsection

@section('content')
    <!-- Modal de bienvenida -->
    <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="welcomeModalLabel">¡Bienvenido a tu primer uso!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Completa los siguientes pasos para gestionar tu sistema
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de opciones en tarjetas -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Mi complejo">
                    <div class="card-body">
                        <h5 class="card-title">Mi Complejo</h5>
                        <p class="card-text">Gestiona los detalles de tu complejo.</p>
                        <a href="#" class="btn btn-primary">Ir a Mi Complejo</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Mis sucursales">
                    <div class="card-body">
                        <h5 class="card-title">Mis Sucursales</h5>
                        <p class="card-text">Gestiona las sucursales de tu sistema.</p>
                        <a href="#" class="btn btn-primary">Ir a Mis Sucursales</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Usuarios">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text">Administra los usuarios de tu sistema.</p>
                        <a href="#" class="btn btn-primary">Ir a Usuarios</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Configuración">
                    <div class="card-body">
                        <h5 class="card-title">Configuración</h5>
                        <p class="card-text">Configura las opciones del sistema.</p>
                        <a href="#" class="btn btn-primary">Ir a Configuración</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')

    <script>
        // Mostrar el modal automáticamente al cargar la página
        window.addEventListener('load', function () {
            var myModal = new mdb.Modal(document.getElementById('welcomeModal'));
            myModal.show();
        });
    </script>
@endsection
