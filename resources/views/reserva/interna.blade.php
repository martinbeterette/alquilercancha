@extends('base')

@section('title', 'Reserva Interna')

@section('extra_stylesheets')
    {{-- Acá podrías agregar estilos personalizados si querés --}}
@endsection

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Buscar Persona por Contacto</h5>
        </div>
        <div class="card-body">
            <form id="form-buscar-persona">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="contacto" class="form-label">Contacto (correo o teléfono)</label>
                        <input type="text" id="contacto" name="contacto" class="form-control" placeholder="Ej: juan@mail.com">
                    </div>
                </div>
                <button type="submit" id="btn-buscar" class="btn btn-primary">
                    Buscar
                </button>
                {{-- Acá después podés poner el botón o más campos si hace falta --}}
            </form>
        </div>
        <div id="resultado-busqueda" class="mt-4">
            @include('reserva.componentes.card_cliente_existente', ['persona' => null])
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
                    alert(persona);
                    $('#nombre-cliente').text(persona.nombre ?? 'No definido');
                    $('#apellido-cliente').text(persona.apellido ?? 'No definido');
                    $('#id-cliente').text(persona.id);
                    $('#card-cliente').removeClass('d-none');
                    $('#form-nuevo-cliente').addClass('d-none');
                })
                .catch(error => {
                    if (error.response && error.response.status === 404) {
                        $('#card-cliente').addClass('d-none');
                        $('#form-nuevo-cliente').removeClass('d-none');
                    } else {
                        console.error("Error inesperado:", error);
                    }
                });
        });

        $('#btn-crear-cliente-nuevo').on('click', function () {
            $('#card-cliente').addClass('d-none');
            $('#form-nuevo-cliente').removeClass('d-none');
        });
    });
</script>
@endsection
