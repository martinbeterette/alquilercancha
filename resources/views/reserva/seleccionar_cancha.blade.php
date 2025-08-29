@extends('base')

@section('title', 'Crear Reserva')

@section('extra_stylesheets')
    {{-- Acá podrías agregar estilos personalizados si querés --}}
@endsection

@section('content')
<div class="container mt-4">

    {{-- Selector de sucursal --}}
    <div class="mb-4">
        <label for="sucursal" class="form-label fw-bold">Elegí la sucursal</label>
        <select name="sucursal" id="sucursal" class="form-select">
            @foreach ($sucursales as $id => $nombre)
                <option value="{{ $id }}">{{ $nombre }}</option>
            @endforeach
        </select>
    </div>

    {{-- Contenedor de canchas --}}
    <div class="row row-cols-1 row-cols-md-3 g-3 canchas-container">
        {{-- Cada cancha se agregará dinámicamente aquí --}}
        {{-- Ejemplo de card de cancha:
        <div class="col">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">Cancha 1</h5>
                    <p class="card-text">Detalles de la cancha...</p>
                    <button class="btn btn-primary btn-sm">Seleccionar</button>
                </div>
            </div>
        </div>
        --}}
    </div>

    {{-- Mensaje cuando no haya canchas --}}
    <div id="no-canchas" class="alert alert-warning mt-3 d-none">
        No hay canchas disponibles en esta sucursal.
    </div>
</div>
@endsection

@section('extra_js')
<script>
    //pasamos la persona
    let persona = @json($persona->id ?? null);

    $(document).ready(function() {
        let id_sucursal = $('#sucursal').val();
        buscarCanchaPorSucursal(id_sucursal);
    }); 

    $('#sucursal').change(function() {
        let id_sucursal = $(this).val();
        buscarCanchaPorSucursal(id_sucursal);
    });
    async function buscarCanchaPorSucursal(id_sucursal) {
        try {
            const response = await axios.get(`/api/sucursal/${id_sucursal}/cancha`);
            const data = response.data;

            if (!data.success) {
                console.error("Error al obtener las canchas");
                return;
            }

            const canchas = data.canchas;

            // contenedor donde van las cards
            const container = document.querySelector(".canchas-container");
            container.innerHTML = ""; // limpiamos contenido previo

            // recorrer canchas y pintar
            canchas.forEach(c => {
                const card = `
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Cancha #${c.id}</h5>
                                <p class="card-text">
                                    <strong>Nombre:</strong> ${c.descripcion ?? 'Sin nombre'} <br>
                                    <strong>Superficie:</strong> ${c.superficie.descripcion ?? 'Sin nombre'} <br>
                                    <strong>Tipo:</strong> ${c.tipo_zona.descripcion ?? 'N/A'} <br>
                                    <strong>Sucursal:</strong> ${c.rela_sucursal}
                                </p>
                                <button class="btn btn-primary btn-seleccionar-cancha" data-id="${c.id}">
                                    Seleccionar Cancha
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += card;
            });

        } catch (error) {
            console.error("Error en la petición:", error);
        }
    }
    $(document).on('click', '.btn-seleccionar-cancha',  function() {
        // alert(persona);
        let cancha = $(this).data('id');
        window.location.href = `/reserva-interna/persona/${persona}/cancha/${cancha}/horario`;
    });
</script>
@endsection
