const API_PROVEEDOR = SERVER + 'Actions/proveedor.php?action=';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {

    // Se llama a la función que muestra el historial
    readRows(API_PROVEEDOR);

});
document.getElementById('search-form').addEventListener('submit', function (event) {

    event.preventDefault();

    // Se llama a la función que realiza la búsqueda.
    searchRows(API_PROVEEDOR, 'search-form');
});
// Para mostrar los productos recientes
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
        <tr>
                        <td>${row.id_proveedor}</td>
                        <td>${row.nombre_prv}</td>
                        <td>${row.contacto}</td>
                        <td>
                        <a onclick="openUpdate(${row.id_proveedor})" data-bs-toggle="modal" data-bs-target="#modalproveedor">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <a onclick="openDelete(${row.id_proveedor})">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                    </td>
                        </tr>
        `;

    });

    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('proveedor-tabla').innerHTML = content;
}
function openCreate() {
    // Se restauran los elementos del formulario.
    document.getElementById('save-form').reset();
    // Se establece el campo de archivo como obligatorio
}



// Función para preparar el formulario al momento de modificar un registro.
function openUpdate(id_proveedor) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_proveedor', id_proveedor);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_PROVEEDOR + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se inicializan los campos del formulario con los datos del registro seleccionado.
                    document.getElementById('id_proveedor').value = response.dataset.id_proveedor;
                    document.getElementById('marca').value = response.dataset.nombre_prv;
                    document.getElementById('correo_pro').value = response.dataset.contacto;
                    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}


document.getElementById('save-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se define una variable para establecer la acción a realizar en la API.
    let action = '';
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
    (document.getElementById('id_proveedor').value) ? action = 'update' : action = 'create';
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_PROVEEDOR, action, 'save-form', 'save-modal');
});

// Función para establecer el registro a eliminar y abrir una caja de diálogo de confirmación.
function openDelete(id_proveedor) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_proveedor', id_proveedor);
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete(API_PROVEEDOR, data);
}