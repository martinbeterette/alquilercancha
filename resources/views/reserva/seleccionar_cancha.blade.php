@extends('base')

@section('title', 'Reserva Interna')

@section('extra_stylesheets')
    {{-- Acá podrías agregar estilos personalizados si querés --}}
@endsection

@section('content')
    <select name="sucursal" id="sucursal">
        @foreach ($sucursales as $id => $nombre)
            <option value="{{ $id }}">{{ $nombre }}</option>
        @endforeach
    </select>

    <div class="row canchas-container"></div>



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
                                    <strong>Nombre:</strong> ${c.nombre ?? 'Sin nombre'} <br>
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
        alert(persona);
        let cancha = $(this).data('id');
        window.location.href = `/reserva-interna/persona/${persona}/cancha/${cancha}/horario`;
    });
</script>
@endsection
