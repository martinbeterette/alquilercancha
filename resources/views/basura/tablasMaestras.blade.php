@extends('base')

@section('title', 'Tablas Maestras')

@section('extra_stylesheets')
    <style>
        .card:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Tablas Maestras</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3 text-center shadow-sm">
                    <h5>Sexos</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center shadow-sm">
                    <h5>Deportes</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center shadow-sm">
                    <h5>Categoría de Productos</h5>
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
