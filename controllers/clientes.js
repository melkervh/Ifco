 //Constante para establecer la ruta y parámetros de comunicación con la API.
const API_CLIENTES= SERVER + 'Actions/clientes.php?action=';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {

    // Se llama a la función que muestra el historial
    readRows(API_CLIENTES);
});
document.getElementById('search-form').addEventListener('submit', function (event) {

    event.preventDefault();

    // Se llama a la función que realiza la búsqueda.
    searchRows(API_CLIENTES, 'search-form');
});
// Para mostrar los productos recientes
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
        <tr>
        <td>${row.nombre_cli}</td>
        <td>${row.apellido_cli}</td>
        <td>${row.DUI}</td>
        <td>${row.telefono}</td>
        <td>
        <a onclick="openUpdate(${row.id_cliente})" data-bs-toggle="modal" data-bs-target="#Modalusuario">
            <i class="fa-solid fa-pen"></i>
        </a>
        <a onclick="openDelete(${row.id_cliente})">
            <i class="fa-solid fa-trash-can"></i>
        </a>
    </td>
        </tr>
        `;

    });

    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('clientes-tabla').innerHTML = content;
    // Función para preparar el formulario al momento de modificar un registro.
}
function openUpdate(id_cliente) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_cliente', id_cliente);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_CLIENTES + 'readOne', {
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
                    document.getElementById('id_cliente').value = response.dataset.id_cliente;
                    document.getElementById('Nombrec').value = response.dataset.nombre_cli;
                    document.getElementById('apellidoc').value = response.dataset.apellido_cli;
                    document.getElementById('DUI').value = response.dataset.DUI;
                    document.getElementById('Telefono').value = response.dataset.telefono;
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
    (document.getElementById('id_cliente').value) ? action = 'update' : action = 'create';
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_CLIENTES, action, 'save-form', 'save-modal');
});

// Función para establecer el registro a eliminar y abrir una caja de diálogo de confirmación.
function openDelete(id_cliente) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_cliente', id_cliente);
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete(API_CLIENTES, data);
}