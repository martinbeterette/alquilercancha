@extends('base')

@php
    $tablasMaestras = [
        (object)['titulo' => 'Roles de Usuario',        'ruta' => route('rol.index')],
        (object)['titulo' => 'Superficies',             'ruta' => route('superficie.index')],
        (object)['titulo' => 'Sexos',                   'ruta' => route('sexo.index')],
        (object)['titulo' => 'Deportes',                'ruta' => route('deporte.index')],
        (object)['titulo' => 'Estado de Zonas',         'ruta' => route('estado_zona.index')],
        // (object)['titulo' => 'Categoría de Productos',  'ruta' => null], // null si todavía no tiene ruta
        (object)['titulo' => 'Tipos de Contactos',      'ruta' => route('tipo_contacto.index')], 
        (object)['titulo' => 'Tipos de Documentos',     'ruta' => route('tipo_documento.index')], 
        (object)['titulo' => 'Tipos de Zonas',          'ruta' => route('tipo_zona.index')], 
        (object)['titulo' => 'Estados de la Reserva',   'ruta' => route('estado_reserva.index')], 
    ];
@endphp

@section('title', 'Tablas Maestras')

@section('extra_stylesheets')
    <style>
        .card:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
        .card-clickable:hover {
            box-shadow: 0 0 0 2px #007bff30;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Tablas Maestras</h2>
        <div class="row">
            @foreach ($tablasMaestras as $tabla)
                <div class="col-md-4 mb-3">
                    <div 
                        class="card p-3 text-center shadow-sm {{ $tabla->ruta ? 'card-clickable' : '' }}"
                        @if ($tabla->ruta)
                            onclick="window.location.href='{{ $tabla->ruta }}'"
                        @endif
                    >
                        <h5>{{ $tabla->titulo }}</h5>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('extra_js')
    <script>
        console.log("Script específico de la página de inicio");
    </script>
@endsection
