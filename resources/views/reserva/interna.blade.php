@extends('base')

@section('title', 'Crear Reserva')

@section('extra_stylesheets')
    {{-- Acá podrías agregar estilos personalizados si querés --}}
@endsection

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold fs-2">Crear una Reserva</h1>
        <p class="text-muted mt-2">Primero buscá la persona por contacto (correo o teléfono). Si no existe, podés crear un nuevo cliente.</p>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Buscar Persona por Contacto</h5>
        </div>
        <div class="card-body">
            <form id="form-buscar-persona" class="row g-3">
                <div class="col-md-8">
                    <input type="text" id="contacto" name="contacto" class="form-control" placeholder="Ej: juan@mail.com o 1122334455" aria-label="Contacto">
                </div>
                <div class="col-md-4 d-grid">
                    <button type="submit" id="btn-buscar" class="btn btn-primary">
                        Buscar Persona
                    </button>
                </div>
            </form>
        </div>

        <div id="resultado-busqueda" class="mt-4">
            {{-- Card para persona existente --}}
            @include('reserva.componentes.card_cliente_existente', ['persona' => null])

            {{-- Formulario para nuevo cliente --}}
            @include('reserva.componentes.form_cliente_nuevo')
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function () {
        $('#form-buscar-persona').on('submit', function (e) {
            e.preventDefault();
            let contacto = $('#contacto').val();
            if (contacto.length < 3) {
                $('#card-cliente, #form-nuevo-cliente').addClass('d-none');
                return;
            }

            axios.get(`/api/buscar-persona/${encodeURIComponent(contacto)}`)
                .then(response => {
                    console.log("Respuesta completa:", response);
                    let persona = response.data.objeto;
                    $('#nombre-cliente').text(persona.nombre ?? 'No definido');
                    $('#apellido-cliente').text(persona.apellido ?? 'No definido');
                    $('#id-cliente').text(persona.id);
                    $('#card-cliente').removeClass('d-none');
                    $('#form-nuevo-cliente').addClass('d-none');

                    // Agregar el onclick al botón
                    $('#btn-seleccionar-cliente').off('click') // Primero quitamos clicks previos para evitar duplicados
                        .on('click', function() {
                            window.location.href = `reserva-interna/persona/${persona.id}/cancha`;
                        });
                })
                .catch(error => {
                    if (error.response && error.response.status === 404) {
                        $('#card-cliente').addClass('d-none');
                        $('#form-nuevo-cliente').removeClass('d-none');
                        $('#contacto-nuevo').val(contacto); // Mantener el contacto ingresado
                        $('#feedback-no-persona').removeClass('d-none'); // Mostramos feedback leve
                    } else {
                        console.error("Error inesperado:", error);
                    }
                });
        });

        $('#btn-crear-cliente-nuevo').on('click', function () {
            $('#card-cliente').addClass('d-none');
            $('#form-nuevo-cliente').removeClass('d-none');
        });
        @if ($errors->any())
            $('#form-nuevo-cliente').removeClass('d-none');
        @endif
    }); //document ready
</script>
@endsection
