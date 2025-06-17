@extends('base')

@php
    // VARIABLES CONFIGURABLES
    $titulo        = "Tipos de Documento";
    $table         = "tipo_documento";
    $entidadSing   = "Tipo de Documento";      // singular bonito
    $entidadPlural = "Tipos de Documento";    // plural bonito
    $rutaInsert    = route("$table.store");
    $rutaIndex     = route("$table.index");
@endphp

@section('title', "Crear $entidadSing")

@section('extra_stylesheets')
@endsection

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Crear {{ ucfirst($entidadSing) }}</h2>
        
        <form action="{{ $rutaInsert }}" method="POST">
            @csrf
            @method('POST')

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="descripcion" 
                    name="descripcion" 
                    value="{{ session('descripcion') ?? '' }}" 
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
            <a href="{{ $rutaIndex }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>    
@endsection

@section('extra_js')
@endsection
