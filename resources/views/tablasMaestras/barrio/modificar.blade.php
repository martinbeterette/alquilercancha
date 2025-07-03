@extends('base')

@php
    // VARIABLES CONFIGURABLES
    $titulo        = "Barrios";
    $table         = "barrio";
    $entidadSing   = "Barrio";
    $entidadPlural = "Barrios";
    $obj           = $objeto; // el objeto a editar
    $rutaUpdate    = route("$table.update", [$table => $obj->id]);
    $rutaIndex     = route("$table.index");
    $campos = [
        ['key' => 'descripcion', 'label' => 'Descripcion', 'tipo' => 'text'],
        [
            'key' => 'rela_localidad',
            'label' => 'Localidad',
            'tipo' => 'select',
            'options' => $localidades,
            'option_value' => 'id',
            'option_label' => 'descripcion'
        ],
    ];
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

            @foreach ($campos as $campo)
                <div class="mb-3">
                    <label for="{{ $campo['key'] }}" class="form-label">{{ $campo['label'] }}</label>

                    @if ($campo['tipo'] === 'text')
                        <input 
                            type="text" 
                            class="form-control" 
                            id="{{ $campo['key'] }}" 
                            name="{{ $campo['key'] }}" 
                            value="{{ old($campo['key'], $obj->{$campo['key']}) }}" 
                            required
                        >
                    
                    @elseif ($campo['tipo'] === 'checkbox')
                        <input 
                            type="checkbox" 
                            id="{{ $campo['key'] }}" 
                            name="{{ $campo['key'] }}" 
                            value="1" 
                            {{ old($campo['key'], $obj->{$campo['key']}) ? 'checked' : '' }}
                        >

                    @elseif ($campo['tipo'] === 'select')
                        <select class="form-select" id="{{ $campo['key'] }}" name="{{ $campo['key'] }}" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($campo['options'] as $option)
                                <option 
                                    value="{{ $option[$campo['option_value']] }}" 
                                    {{ $obj->{$campo['key']} == $option[$campo['option_value']] ? 'selected' : '' }}
                                >
                                    {{ $option[$campo['option_label']] }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            @endforeach


            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ $rutaIndex }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>    
@endsection

@section('extra_js')
@endsection
