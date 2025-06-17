@extends('base')

@php
    // VARIABLES CONFIGURABLES
    $titulo        = "Estados de las Reservas";
    $table         = "estado_reserva";
    $entidadSing   = "Estado de Reserva"; // singular bonito para mostrar en frases
    $entidadPlural = "Estados de las Reservas"; // plural para el título y más
    $apiUrl        = "/api/estado-reserva"; 
    $urlEliminar   = "/tablas-maestras/estado-reserva/";
    $urlModificar  = "/tablas-maestras/estado-reserva/";
    $columnas      = ['id', 'descripcion']; // columnas que renderiza JS
@endphp

@section('title', ucfirst($entidadPlural))

@section('extra_stylesheets')
@endsection

@section('content')
    <h2 class="text-center my-4">{{ ucfirst($entidadPlural) }}</h2>

    {{-- Filtros --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" id="filtro" class="form-control" placeholder="Buscar...">
        </div>
        <div class="col-md-6">
            <select id="campo-filtro" class="form-select">
                @foreach ($columnas as $col)
                    <option value="{{ $col }}">{{ ucfirst($col) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Tabla --}}
    <div id="tabla-container" class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle mb-0 bg-white">
            <thead class="table-dark">
                <tr>
                    @foreach ($columnas as $col)
                        <th>{{ strtoupper($col) }}</th>
                    @endforeach
                    <th colspan="2">ACCIONES</th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>

    <div class="mb-3 text-end">
        <a href="{{ route("$table.create") }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Crear {{ ucfirst($entidadSing) }}
        </a>
    </div>

    <div id="paginator" class="d-flex justify-content-center mt-4"></div>

    {{-- Modal de confirmación --}}
    <div class="modal fade" id="modalConfirmDelete" tabindex="-1" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalConfirmDeleteLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que querés eliminar este {{ $entidadSing }}? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="confirmarEliminar()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <form id="form-eliminar" action="" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('extra_js')
    <script>
        let url               = '{{ $apiUrl }}';
        let data              = { registros_por_pagina: 5 };
        let campos            = @json($columnas);
        let page              = 1;
        let urlDeEliminacion  = '{{ $urlEliminar }}';
        let urlDeModificacion = '{{ $urlModificar }}';
    </script>
    <script src="{{ asset('js/utils.js') }}"></script>
    <script src="{{ asset('js/masterTableRender.js') }}"></script>
@endsection
