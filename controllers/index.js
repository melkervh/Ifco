// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_DETALLES = SERVER + 'Actions/detalles.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {

    // Se llama a la función que muestra el historial
    openShowFechas();
});

// Para mostrar los productos recientes
function openShowFechas() {

    // Petición para obtener los datos del registro solicitado.
    fetch(API_DETALLES  + 'showFechas', {
        method: 'get'
    }).then(function (request) {

        // Se verifica si la petición es correcta.
        if (request.ok) {
            request.json().then(function (response) {

                let data = [];
                // Se comprueba si la respuesta es satisfactoria.
                if (response.status) {

                    data = response.dataset;
                    let content = '';
                    data.map(function (row) {

                        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                        content += `
                        <tr>
                        <td>${row.nombre_prodroducto}</td>
                        <td>${row.descripcion_producto}</td>
                        <td>$${row.cantidad_prodroducto}</td>
                        <td>${row.precio_unidad}</td>
                        </tr>
                        `
                    });

                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('productos-tabla').innerHTML = content;

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Para mostrar los productos recientes
function openShowFechasc() {

    // Petición para obtener los datos del registro solicitado.
    fetch(API_DETALLES  + 'showFechasc', {
        method: 'get'
    }).then(function (request) {

        // Se verifica si la petición es correcta.
        if (request.ok) {
            request.json().then(function (response) {

                let data = [];
                // Se comprueba si la respuesta es satisfactoria.
                if (response.status) {

                    data = response.dataset;
                    let content = '';
                    data.map(function (row) {

                        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                        content += `
                            <tr>
                            <td>${row.nombre_prodroducto}</td>
                            <td>${row.descripcion_producto}</td>
                            <td>$${row.cantidad_prodroducto}</td>
                            <td>${row.precio_unidad}</td>
                            </tr>
                        `
                    });

                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('productosrec-tabla').innerHTML = content;

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}