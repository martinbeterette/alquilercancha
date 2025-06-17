
document.addEventListener('DOMContentLoaded', function() {
    renderTable(url, data, campos, page);
});

$(document).on('click','.page-btn', function() {
    let page = $(this).data('page');

  
    
    renderTable(url, data, campos, page);
});

$(document).on('keyup', '#filtro', function () {
    let valor = $(this).val();
    data.filtro = valor; 
    renderTable(url, data, campos, page);
});