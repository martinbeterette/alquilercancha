@extends('base')

@php
    // VARIABLES CONFIGURABLES
    $titulo        = "Provincias";
    $table         = "provincia";
    $entidadSing   = "Provincia";
    $entidadPlural = "Provincias";
    $rutaInsert    = route("$table.store");
    $rutaIndex     = route("$table.index");

    $campos = [
        ['key' => 'descripcion', 'label' => 'Descripción', 'tipo' => 'text'],
    ];
@endphp

@section('title', "Crear $entidadSing")

@section('content')
<div class="container mt-4">
    <a href="{{ $rutaIndex }}" class="btn btn-outline-secondary mb-4">
        ← Volver
    </a>
    <h2 class="mb-4">Crear {{ ucfirst($entidadSing) }}</h2>
    
    <form action="{{ $rutaInsert }}" method="POST">
        @csrf

        @foreach ($campos as $campo)
            <div class="mb-3">
                <label for="{{ $campo['key'] }}" class="form-label">{{ $campo['label'] }}</label>

                @if ($campo['tipo'] === 'text')
                    <input 
                        type="text" 
                        class="form-control" 
                        id="{{ $campo['key'] }}" 
                        name="{{ $campo['key'] }}" 
                        value="{{ old($campo['key']) }}" 
                        required
                    >

                @elseif ($campo['tipo'] === 'checkbox')
                    <input 
                        type="checkbox" 
                        id="{{ $campo['key'] }}" 
                        name="{{ $campo['key'] }}" 
                        value="1" 
                        {{ old($campo['key']) ? 'checked' : '' }}
                    >

                @elseif ($campo['tipo'] === 'select')
                    <select class="form-select" id="{{ $campo['key'] }}" name="{{ $campo['key'] }}" required>
                        <option value="">Seleccionar...</option>
                        @foreach ($campo['options'] as $option)
                            <option 
                                value="{{ $option[$campo['option_value']] }}" 
                                {{ old($campo['key']) == $option[$campo['option_value']] ? 'selected' : '' }}
                            >
                                {{ $option[$campo['option_label']] }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Enviar</button>
        <a href="{{ $rutaIndex }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
