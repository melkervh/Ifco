const API_PROVEEDORES = SERVER + 'Actions/proveedor.php?action=';

document.getElementById('searchP-form').addEventListener('submit', function (event) {

    event.preventDefault();

    // Se llama a la función que realiza la búsqueda.
    searchRows(API_PROVEEDORES, 'searchP-form');
});