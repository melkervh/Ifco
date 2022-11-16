// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_HISTORIAL = SERVER + 'Actions/historial.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {

    // Se llama a la función que muestra el historial
    readRows(API_HISTORIAL);
});

// Para cargar la base de datos.
// Función para llenar la tabla con los datos de los registros. 
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
            <tr>
                <td class="texto3">${row.nombre_cli}</td>
                <td class="texto3">${row.fecha_fn}</td>
                <td class="texto3  justify-content-center"> <a onclick="openFactura(${row.id_fact_nor})" class="btn btn-dark">
                <i class="fa-solid fa-circle-info cart_nav1"></i></a></td>
            </tr>
        `;

    });

    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('historial-tabla').innerHTML = content;
}
// Buscador.
// Método manejador de eventos que se ejecuta cuando se envía el formulario de buscar.
document.getElementById('search-form').addEventListener('submit', function (event) {

    event.preventDefault();

    // Se llama a la función que realiza la búsqueda.
    searchRows(API_HISTORIAL, 'search-form');
});
function openDetalle(id) {

    const data = new FormData();
    data.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_HISTORIAL + 'readAlld', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    let content = '';
                    let total = 0;
                    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        total += (row.cantidad_com * row.precio_u);
                        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                        content += `
                            <tr> 
                                <td class="text-center">${row.nombre_prodroducto}</td>
                                <td class="text-center">${row.descripcion_producto}</td>
                                <td class="text-center">${row.precio_u}</td>
                                <td class="text-center">${row.cantidad_com}</td>
                                <td class="text-center">${(row.cantidad_com * row.precio_u).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('tbody-rows-detalle').innerHTML = content;
                    document.getElementById('total').textContent = total.toFixed(2);
                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}
    // Reporte para generar factura
    function openFactura(id){

        // Se establece la ruta del reporte en el servidor.
        let url = SERVER + 'reports/factura_normal.php?id=' + id ;
        // Se abre el reporte en una nueva pestaña del navegador web.
        window.open(url);
    }
