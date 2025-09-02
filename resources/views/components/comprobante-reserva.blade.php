{{-- 
Componente Blade para mostrar un comprobante de reserva de cancha.
Parámetros:
- persona: Objeto con información de la persona que realiza la reserva.
- cancha: Objeto con información de la cancha reservada.
- sucursal: Objeto con información de la sucursal donde se encuentra la cancha.
- fecha: Fecha de la reserva.
- hora_desde: Hora de inicio de la reserva.
- hora_hasta: Hora de fin de la reserva.
uso:
<x-comprobante-reserva 
    :persona="$persona" 
    :cancha="$cancha" 
    :sucursal="$sucursal" 
    :fecha="$fecha" 
    :hora_desde="$hora_desde" 
    :hora_hasta="$hora_hasta" 
/>
--}}

<div class="card shadow-sm rounded">
    <div class="card-header text-white py-2 px-3" style="background-color: #0d6efd;">
        <h5 class="mb-0"><i class="bi bi-journal-check me-2"></i> Comprobante de Reserva</h5>
    </div>
    <div class="card-body p-3">
        <p class="mb-1"><strong>Reservante:</strong> {{ $persona->nombre ?? '' }} {{ $persona->apellido ?? '' }}</p>
        <p class="mb-1"><strong>Sucursal:</strong> {{ $sucursal->nombre ?? 'N/A' }}</p>
        <p class="mb-1"><strong>Cancha:</strong> {{ $cancha->descripcion ?? '' }} ({{ $cancha->superficie->descripcion ?? '' }})</p>
        <p class="mb-1"><strong>Fecha:</strong> {{ $fecha }}</p>
        <p class="mb-1"><strong>Horario:</strong> {{ $desde }} - {{ $hasta }}</p>

    </div>
</div>