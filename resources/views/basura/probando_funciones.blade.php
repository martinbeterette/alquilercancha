@extends('base')

@section('title', 'Tabla Personas')

@section('extra_stylesheets')
    
@endsection

@section('content')
    <h2 class="text-center my-4">Tabla de Personas</h2>
    {{-- Filtros --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" id="filtro" class="form-control" placeholder="Buscar...">
        </div>
        <div class="col-md-6">
            <select id="campo-filtro" class="form-select">
                <option value="nombre">Nombre</option>
                <option value="apellido">Apellido</option>
                <option value="fecha_nacimiento">Fecha de Nacimiento</option>
            </select>
        </div>
    </div>

    {{-- Tabla --}}
    <div id="tabla-container" class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle mb-0 bg-white">
            <thead class="table-dark">
                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>FECHA DE NACIMIENTO</th>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>
    <div id="paginator" class="d-flex justify-content-center mt-4"></div>
@endsection

@section('extra_js')
    <script src="{{ asset('js/utils.js') }}"></script>
    <script>
        let url = '/api/personas';
        let data = {registros_por_pagina:5};
        let campos = ['nombre', 'apellido', 'fecha_nacimiento'];
        let page = 1; // Página inicial
    </script>
    <script src="{{ asset('js/masterTableRender.js') }}"></script>
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            renderTable('/api/personas', {}, ['nombre', 'apellido', 'fecha_nacimiento']);
        });
    </script> --}}
@endsection

