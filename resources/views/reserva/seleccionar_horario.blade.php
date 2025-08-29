@extends('base')

@section('title', 'Seleccionar Horario')

@section('extra_stylesheets')
    {{-- Estilos opcionales --}}
@endsection

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded">
        <div class="card-header text-white py-2 px-3" style="background-color: #198754;">
            <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Seleccionar Horario para Reserva</h5>
        </div>
        <div class="card-body p-3">

            {{-- Información de la persona y la cancha --}}
            @if(isset($persona) && isset($cancha))
                <div class="mb-3">
                    <p class="mb-1"><strong>Persona:</strong> {{ $persona->nombre ?? 'No definido' }} {{ $persona->apellido ?? '' }}</p>
                    <p class="mb-0"><strong>Cancha:</strong> {{ $cancha->descripcion ?? 'Sin nombre' }} ({{ $cancha->superficie->descripcion ?? 'N/A' }})</p>
                </div>
            @endif

            {{-- Formulario de selección de horario --}}
            <form 
                id="form-seleccionar-horario" 
                action="{{ route('crear.reserva', [
                    'persona' => $persona,
                    'cancha'  => $cancha,
                ]) }}" 
                method="POST"
            >
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="fecha" class="form-label fw-bold">Fecha de Reserva</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="hora_desde" class="form-label fw-bold">Horario Desde</label>
                        <input type="time" id="hora_desde" name="hora_desde" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="hora_hasta" class="form-label fw-bold">Horario Hasta</label>
                        <input type="time" id="hora_hasta" name="hora_hasta" class="form-control" required>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg">Confirmar Horario</button>
                </div>
            </form>

            {{-- Mensaje de confirmación --}}
            <div id="mensaje-confirmacion" class="alert alert-success mt-3 d-none"></div>

        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function () {
        $('#form-seleccionar-horario').on('submit', function(e) {
            e.preventDefault();

            let horaDesde = $('#hora_desde').val();
            let horaHasta = $('#hora_hasta').val();
            let fecha     = $('#fecha').val();

            if (!horaDesde || !horaHasta) {
                alert("Debés seleccionar ambos horarios");
                return;
            }

            if (horaDesde >= horaHasta) {
                alert("El horario 'Desde' debe ser anterior al 'Hasta'");
                return;
            }

            if (!fecha) {
                alert("Debés seleccionar una fecha");
                return;
            }

            $(this).off('submit').submit(); // Desactiva el evento submit para evitar bucles

        });
    });
</script>
@endsection
