function activoFormatter(valor) {
  return valor
    ? '<span class="badge bg-success">Sí</span>'
    : '<span class="badge bg-danger">No</span>';
}

async function renderTable(url, data = {}, campos = [],page = 1) {
  try {
    const response = await axios.get(url, {
      params: {
        ...data,
        page: page
      }
    });
    // en el success de ajax hacia esto
    const container = document.querySelector('#table-body');
    container.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos datos

    const paginaActual = response.data.pagina;
    const totalPaginas = response.data.total_paginas;

    response.data.data.forEach(row => {

      const contenido = campos.map(campo => 
        `<td>
          ${row[campo]}
        </td>`
      ).join('');

      // Agregamos botones de acción (modificar y eliminar)
      const botones = `
        <td>
          <button 
            class="btn btn-outline-primary btn-sm" 
            data-id="${row.id}" 
            onclick="window.location.href='${urlDeModificacion}${row.id}/edit'"

          >
            <i class="fas fa-edit"></i> Modificar
          </button>
        </td>
        <td>
          <button class="btn btn-outline-danger btn-sm" data-id="${row.id}" onclick="eliminar(${row.id})">
            <i class="fas fa-trash-alt"></i> Eliminar
          </button>
        </td>
      `;

      container.innerHTML += `
        <tr>
          ${contenido}
          ${botones}
        </tr>
      `;
    });
    // Actualizar la paginación
    renderPagination(totalPaginas, paginaActual);
    return true
  } catch (error) {
    console.error("Error al obtener los datos: ", error);
    return [];
  }
};

async function renderRelationalTable(url, data = {}, campos = [], page = 1) {
  try {
    const response = await axios.get(url, {
      params: {
        ...data,
        page: page
      }
    });

    const container = document.querySelector('#table-body');
    container.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos datos

    const paginaActual = response.data.pagina;
    const totalPaginas = response.data.total_paginas;

    response.data.data.forEach(row => {
      const contenido = campos.map(campo => {
        let valor = getNestedValue(row, campo.key); // <-- ahora soporta "relacion.campo"

        if (campo.formatter && typeof window[campo.formatter] === 'function') {
          valor = window[campo.formatter](valor);
        }

        return `<td>${valor}</td>`;
      }).join('');

      const botones = `
        <td>
          <button 
            class="btn btn-outline-primary btn-sm" 
            data-id="${row.id}" 
            onclick="window.location.href='${urlDeModificacion}${row.id}/edit'">
            <i class="fas fa-edit"></i> Modificar
          </button>
        </td>
        <td>
          <button class="btn btn-outline-danger btn-sm" data-id="${row.id}" onclick="eliminar(${row.id})">
            <i class="fas fa-trash-alt"></i> Eliminar
          </button>
        </td>
      `;

      container.innerHTML += `
        <tr>
          ${contenido}
          ${botones}
        </tr>
      `;
    });

    renderPagination(totalPaginas, paginaActual);
    return true;
  } catch (error) {
    console.error("Error al obtener los datos: ", error);
    return [];
  }
}


function renderPagination(total_pages, current_page) {
  let paginacionHTML = `
    <nav aria-label="Paginación">
        <ul class="pagination justify-content-center">
  `;

  // Generar botones de paginación
  for (let i = 1; i <= total_pages; i++) {
    paginacionHTML += `
      <li class="page-item ${i === current_page ? 'active' : ''}">
        <button class="page-btn page-link bg-dark text-white border-secondary" data-page="${i}">
          ${i}
        </button>
      </li>
    `;
  }

  document.querySelector('#paginator').innerHTML = paginacionHTML;
}


//eliminacion de registro
let idAEliminar = null;

function eliminar(id) {
  idAEliminar = id;
  const modal = new mdb.Modal(document.getElementById('modalConfirmDelete'));
  modal.show();
}
function confirmarEliminar() {
  if (idAEliminar) {
    let form = document.getElementById('form-eliminar');
    // form.action = `/tablas-maestras/rol/eliminar/${idAEliminar}`;
    form.action = `${urlDeEliminacion}${idAEliminar}`;
    document.getElementById(`form-eliminar`).submit();
    // window.location.href = `/url-de-prueba-${idAEliminar}`;
  }
}

function getNestedValue(obj, path) {
  return path.split('.').reduce((acc, part) => acc && acc[part], obj) ?? '';
}

const contenido = campos.map(campo => {
  let valor = getNestedValue(row, campo.key);
  if (campo.formatter) valor = campo.formatter(valor);
  return `<td>${valor}</td>`;
}).join('');

