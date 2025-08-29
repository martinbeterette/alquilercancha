<div class="card d-none shadow-sm rounded" id="form-nuevo-cliente">
    <div class="card-header bg-primary text-white d-flex align-items-center">
        <i class="bi bi-person-plus me-2"></i> Crear cliente nuevo
    </div>
    <div class="card-body">
        {{-- Feedback cuando no se encuentra persona --}}
        <div id="feedback-no-persona" class="alert alert-info d-none">
            No se encontró ninguna persona con ese contacto. Podés crear un cliente nuevo.
        </div>

        <form action="{{ route('cliente_nuevo.create') }}" method="POST" id="crear-reservante">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nuevo-nombre" class="form-label">Nombre</label>
                    <input type="text" id="nuevo-nombre" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Juan Perez">
                </div>
                <div class="col-md-6">
                    <label for="contacto-nuevo" class="form-label">Contacto</label>
                    <input type="text" name="contacto" id="contacto-nuevo" class="form-control" value="{{ old('contacto') }}" placeholder="correo@example.com">
                    {{-- Futuramente: select de tipo contacto --}}
                    <input type="hidden" name="tipo_contacto" value="1">
                </div>
            </div>

            <div class="mt-3 d-grid">
                <button type="submit" id="btn-crear-cliente-nuevo" class="btn btn-primary">
                    Crear cliente nuevo
                </button>
            </div>
        </form>
    </div>
</div>