<div class="card d-none" id="form-nuevo-cliente">
    <div class="card-header bg-warning">
        Crear cliente nuevo
    </div>
    <div class="card-body">
        <form action="{{ route('cliente_nuevo.create') }}" method="POST" id="crear-reservante">
            @csrf
            <div class="mb-3">
                <label for="nuevo-nombre" class="form-label" placeholder="Juan Perez">Nombre</label>
                <input type="text" id="nuevo-nombre" name="nombre" class="form-control" value="{{ old('nombre') }}">
                <label for="contacto" class="form-label" placeholder="correo@example.com">Contacto</label>
                <input type="text" name="contacto" id="contacto" class="form-control" value="{{ old('contacto') }}">
                {{-- futuramente hay que agregar un select de tipo contacto --}}
                <input type="hidden" name="tipo-contacto" value="1">
            </div>
            {{-- Otros campos --}}
            <div>
                <button type="submit" id="btn-crear-cliente-nuevo" class="btn btn-outline-secondary">
                    Crear cliente nuevo
                </button>
            </div>
        </form>
    </div>
</div>
