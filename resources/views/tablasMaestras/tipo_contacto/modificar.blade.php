@extends('base')

@php
    // VARIABLES CONFIGURABLES
    $titulo        = "Tipos de Contactos";
    $table         = "tipo_contacto";
    $entidadSing   = "Tipo de Contacto"; // para textos
    $entidadPlural = "Tipos de Contactos";
    $obj           = $objeto; // el objeto a editar
    $rutaUpdate    = route("$table.update", ["$table" => $obj->id]);
    $rutaIndex     = route("$table.index");
@endphp

@section('title', "Modificar $entidadSing")

@section('extra_stylesheets')
@endsection

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Modificar {{ ucfirst($entidadSing) }}</h2>
        
        <form action="{{ $rutaUpdate }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="descripcion" 
                    name="descripcion" 
                    value="{{ old('descripcion', $obj->descripcion) }}" 
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ $rutaIndex }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>    
@endsection

@section('extra_js')
@endsection
