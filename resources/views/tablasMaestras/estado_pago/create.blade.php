@extends('base')

@section('content')
<div class="container my-4">
    <h2>Crear Estado de Pago</h2>

    <form action="{{ route('estado_pago.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" 
                   class="form-control @error('descripcion') is-invalid @enderror" 
                   value="{{ old('descripcion') }}">
            {{-- @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror --}}
        </div>

        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="{{ route('estado_pago.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection