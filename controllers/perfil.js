// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_PERFIL = SERVER + 'Actions/lista.php?action=';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {

    // Se llama a la función que muestra el historial
    openUpdate();
    openUpdate2();
});

// Función para preparar el formulario al momento de modificar un registro.
function openUpdate(id_usuario) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_usuario', id_usuario);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_PERFIL + 'readOne', {
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
// Función para preparar el formulario al momento de modificar un registro.
function openUpdate2(id_usuario) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_usuario', id_usuario);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_PERFIL + 'readOne2', {
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
    saveRow(API_PERFIL, action, 'save-form', 'save-modal');
});
document.getElementById('clave-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se define una variable para establecer la acción a realizar en la API.
    let action = '';
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
    (document.getElementById('id_usuario').value) ? action = 'update2' : action = 'create';
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_PERFIL, action, 'clave-form', 'save-form');
});

