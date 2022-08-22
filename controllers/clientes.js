 //Constante para establecer la ruta y parámetros de comunicación con la API.
const API_CLIENTES= SERVER + 'Actions/clientes.php?action=';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {

    // Se llama a la función que muestra el historial
    readRows(API_CLIENTES);
});
// Para mostrar los productos recientes
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        //En la linea 29, se llama a la funcion para que se abra una nueva ventana la darle clic al icono
        content += `
        <tr>
        <td>${row.nombre_cli}</td>
        <td>${row.apellido_cli}</td>
        <td>${row.DUI}</td>
        <td>${row.telefono}</td>
        <td>
        <a onclick="openUpdate(${row.id_cliente})" data-bs-toggle="modal" data-bs-target="#usuaiosA">
            <i class="fa-solid fa-pen"></i>
        </a>
        <a onclick="openDelete(${row.id_cliente})">
            <i class="fa-solid fa-trash-can"></i>
        </a>
        <a  onclick="openReporteInfor()"(${row.id_cliente})">
        <i class="fa-solid fa-file-pdf"></i>
        </a>
    </td>
        </tr>
        `;

    });

    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('clientes-tabla').innerHTML = content;
}
//Se inicia el codigo para la funcion del reporte parametrizado del cliente y su respectivo departamento.
//Esta misma funcion nos permite hacer funcionar el boton para abrir el reporte.
function openReporteInfor() {
    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/reporte_ubicacion.php';
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}