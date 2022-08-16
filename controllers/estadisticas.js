// Constantes para establecer las rutas y parámetros de comunicación con la API.
//Parametros para el reposte de productos
//Constantes para el reporte del estado de los productos 
const API_PRODUCTOS = SERVER + 'Actions/productos.php?action=';
const ENDPOINT_CATEGORIAS = SERVER + 'Actions/marcas.php?action=readAll';
//Se inicia el codigo para la funcion del reporte para los productos y sus marcas.
//Esta misma funcion nos permite hacer funcionar el boton para abrir el reporte.
function openReporteProduc() {
    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/reporte_producto.php';
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}
//Se inicia el codigo para la funcion del reporte de los estados por productos.
//Esta misma funcion nos permite hacer funcionar el boton para abrir el reporte.
function openReporteEstado() {
    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/reporte_estadopro.php';
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}

