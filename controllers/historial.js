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
                <td scope="row" class="texto2">${row.id_fact_nor}</td>
                <td class="texto3">pdf</td>
                <td class="texto3">${row.nombre_cli}</td>
                <td class="texto3">${row.fecha_fn}</td>
                <td class="texto3"> <a class="btn btn-primary" href="modificar_prover.html" role="button">Vista</a>
                </td>
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