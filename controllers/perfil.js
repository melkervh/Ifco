// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_PERFIL = SERVER + 'Actions/lista.php?action=';
const API_USUARIOS = SERVER + 'Actions/usuario.php?action=';

let two_factor = false;
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    //Se bloquea el pegar en el input
    var myInput = document.getElementById('clave_actual');
    myInput.onpaste = function (e) {
        e.preventDefault();
        sweetAlert(3, "Esta acción no esta disponible", null);
    }

    //Se bloquea el pegar en el input
    var myInput1 = document.getElementById('clave_usuario');
    myInput1.onpaste = function (e) {
        e.preventDefault();
        sweetAlert(3, "Esta acción no esta disponible", null);
    }

    //Se bloquea el pegar en el input
    var myInput2 = document.getElementById('confirmar');
    myInput2.onpaste = function (e) {
        e.preventDefault();
        sweetAlert(3, "Esta acción no esta disponible", null);
    }

    // Se llama a la función que muestra el historial
    openUpdate();

    peticiones_user('knownTwoFactor', twoFactor);
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

//Función para cargar los datos del usuario en los inputs
function twoFactor(response){
    document.getElementById('generateQR').innerText = (response.dataset.two_factor ? 'Desactivar' : 'Activar') + ' autenticación en 2 pasos'
    two_factor = response.dataset.two_factor;
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de guardar.
document.getElementById('generateQR').addEventListener('click', () => {
    if (two_factor) {
        peticiones_user('deactivate2fa', deactivate2fa, true);
    } else {
        peticiones_user('activate2fa', activate2fa, true);
    }

});

function activate2fa(response){
    //Se declara e inicializa al elemento de Bootstrap
    var modal = new bootstrap.Modal(document.getElementById('twoFactor'));
    modal.show();
    document.getElementById('imgQR').setAttribute('src', response.dataset);
    document.getElementById('generateQR').innerText = 'Desactivar autenticación en 2 pasos';
    two_factor = true;
}

function deactivate2fa() {
    document.getElementById('imgQR').setAttribute('src', '');
    document.getElementById('generateQR').innerText = 'Activar autenticación en 2 pasos';
    two_factor = false;
}

function peticiones_user(action, func, error){
    fetch(API_USUARIOS + action, {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si existe una sesión, de lo contrario se revisa si la respuesta es satisfactoria.
                if (response.status) {
                    if (error) sweetAlert(1, response.message);
                    if (func) func(response);
                } else {
                    sweetAlert(2, response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}