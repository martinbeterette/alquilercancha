@extends('base')
@section('extra_stylesheets')
    <link href="{{ asset('vendor/css/select2.min.css') }}" rel="stylesheet" />

@endsection

@section('content')
<div class="container my-4">
    <h2>Agregar Módulo</h2>

    <form action="{{ route('modulos.store') }}" method="POST">
        @csrf

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        {{-- Slug --}}
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" required>
        </div>

        {{-- Icon --}}
        <div class="mb-3">
    <label for="icon" class="form-label">Icono</label>
        <select name="icon" id="icon" class="form-control">
            @foreach($icons as $label => $class)
                <option value="{{ $class }}" data-icon="{{ $class }}" @selected(old('icon') == $class)>
                    <i class="{{ $class }}"></i> {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

        {{-- Roles --}}
        <div class="mb-3">
            <label class="form-label">Roles asignados</label>
            <div class="d-flex flex-wrap">
                @foreach($roles as $role)
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role{{ $role->id }}">
                        <label class="form-check-label" for="role{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success">Crear Módulo</button>
        <a href="{{ route('modulos.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection

@section('extra_js')
<script src="{{ asset('vendor/libs/select2.min.js') }}"></script>
<script> 
    $('#icon').select2({
        templateResult: function(data) {
            if (!data.id) return data.text;
            var iconClass = $(data.element).data('icon');
            return $('<span><i class="' + iconClass + '"></i> ' + data.text + '</span>');
        },
        templateSelection: function(data) {
            if (!data.id) return data.text;
            var iconClass = $(data.element).data('icon');
            return $('<span><i class="' + iconClass + '"></i> ' + data.text + '</span>');
        }
    });
</script>

@endsection