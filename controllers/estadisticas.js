const API_PRODUCTOS = SERVER + 'Actions/productos.php?action=';
const ENDPOINT_CATEGORIAS = SERVER + 'Actions/marcas.php?action=readAll';

//Se inicia el codigo para la funcion del reporte para los productos y sus marcas.
function openReporteProduc() {
    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/reporte_producto.php';
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}

