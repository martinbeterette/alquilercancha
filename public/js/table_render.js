
document.addEventListener('DOMContentLoaded', function() {
    renderRelationalTable(url, data, campos, page);
});

$(document).on('click','.page-btn', function() {
    let page = $(this).data('page');

  
    
    renderRelationalTable(url, data, campos, page);
});

$(document).on('keyup', '#filtro', function () {
    let valor = $(this).val();
    data.filtro = valor; 
    renderRelationalTable(url, data, campos, page);
});