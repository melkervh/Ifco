// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_LISTA = SERVER + 'Actions/lista.php?action=';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {

    // Se llama a la función que muestra el historial
    readRows(API_LISTA);
});
document.getElementById('search-form').addEventListener('submit', function (event) {

    event.preventDefault();

    // Se llama a la función que realiza la búsqueda.
    searchRows(API_LISTA, 'search-form');
});
// Para mostrar los productos recientes
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
        <tr>
        <td>${row.id_usuario}</td>
        <td>${row.nombre_usuario}</td>
        <td>${row.apellido_usuario}</td>
        <td>${row.correo_usuario}</td>
        <td>
        <a onclick="openDelete(${row.id_usuario})">
            <i class="fa-solid fa-trash-can"></i>
        </a>
    </td>
        </tr>
        `;

    });

    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('usuarios-tabla').innerHTML = content;
}
function openCreate() {
    // Se restauran los elementos del formulario.
    document.getElementById('save-form').reset();
    // Se establece el campo de archivo como obligatorio
}



// Función para preparar el formulario al momento de modificar un registro.
function openUpdate(id_usuario) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_usuario', id_usuario);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_LISTA + 'readOne', {
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
                    document.getElementById('id_usuario').value = response.dataset.id_usuario;
                    document.getElementById('nombre_usuario').value = response.dataset.nombre_usuario;
                    document.getElementById('apellido_usuario').value = response.dataset.apellido_usuario;
                    document.getElementById('correo_usuario').value = response.dataset.correo_usuario;
                    document.getElementById('clave_usuario').value = response.dataset.clave_usuario;
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
    (document.getElementById('id_usuario').value) ? action = 'update' : action = 'create';
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_LISTA, action, 'save-form', 'save-modal');
});

// Función para establecer el registro a eliminar y abrir una caja de diálogo de confirmación.
function openDelete(id_usuario) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_usuario', id_usuario);
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete(API_LISTA, data);
}
