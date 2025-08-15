@extends('base')

@section('title', 'Probando Extensión')

@section('extra_stylesheets')

@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm w-50 mx-auto">
            <div class="card-body">
                <h4 class="card-title mb-4">Cambiar contraseña</h4>

                <form action="/perfil/cambiar-contraseña" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="password" class="form-label"><strong>Contraseña actual</strong></label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_nueva" class="form-label"><strong>Nueva contraseña</strong></label>
                        <input type="password" name="password_nueva" id="password_nueva" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label for="confirmar_password" class="form-label"><strong>Confirmar nueva contraseña</strong></label>
                        <input type="password" name="confirmar_password" id="confirmar_password" class="form-control" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('extra_js')

@endsection
