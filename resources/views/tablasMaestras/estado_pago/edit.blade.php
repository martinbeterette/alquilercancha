@extends('base')
@section('content')
<div class="container my-4">
    <h2>Editar Estado de Pago</h2>

    <form action="{{ route('estado_pago.update', $estadoPago) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input 
                type="text" 
                name="descripcion" 
                id="descripcion"
                class="form-control @error('descripcion') is-invalid @enderror"
                value="{{ old('descripcion', $estadoPago->descripcion) }}"
            >
            {{-- @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror --}}
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('estado_pago.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
