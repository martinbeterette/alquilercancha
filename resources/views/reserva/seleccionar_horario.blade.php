@extends('base')

@section('title', 'Seleccionar Horario')

@section('extra_stylesheets')
    {{-- Estilos opcionales --}}
@endsection

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Seleccionar Horario para Reserva</h5>
        </div>
        <div class="card-body">
            {{-- Información de la persona y la cancha --}}
            @if(isset($persona) && isset($cancha))
                <p>
                    <strong>Persona:</strong> {{ $persona->nombre ?? 'No definido' }} {{ $persona->apellido ?? '' }} <br>
                    <strong>Cancha:</strong> {{ $cancha->descripcion ?? 'Sin nombre' }} ({{ $cancha->superficie->descripcion ?? 'N/A' }})
                </p>
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
                <div class="col-md-6">
                    <label for="fecha" class="form-label">Fecha de Reserva</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="hora_desde" class="form-label">Horario Desde</label>
                        <input type="time" id="hora_desde" name="hora_desde" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="hora_hasta" class="form-label">Horario Hasta</label>
                        <input type="time" id="hora_hasta" name="hora_hasta" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Confirmar Horario</button>
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
