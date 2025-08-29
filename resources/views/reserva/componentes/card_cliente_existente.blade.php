<div class="card d-none shadow-sm rounded" id="card-cliente">
    <div class="card-header text-white py-2 px-3" style="background-color: #198754;"> {{-- verde bootstrap suavizado --}}
        <i class="bi bi-person-check me-2"></i> Registro encontrado
    </div>
    <div class="card-body p-3">
        <p class="mb-1"><strong>Nombre:</strong> <span id="nombre-cliente"></span></p>
        <p class="mb-1"><strong>Apellido:</strong> <span id="apellido-cliente"></span></p>
        <p class="mb-3"><strong>ID:</strong> <span id="id-cliente"></span></p>

        <div class="d-flex gap-2">
            <button type="button" id="btn-seleccionar-cliente" class="btn btn-success flex-grow-1">
                Seleccionar este cliente
            </button>
            <button type="button" id="btn-crear-cliente-nuevo" class="btn btn-outline-secondary flex-grow-1">
                Crear cliente nuevo
            </button>
        </div>
    </div>
</div>
