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

function reportClientes(){

    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/reporte_cliente.php' ;
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}

// Reporte para proveedores
function reportProveedores(){

    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/reporte_proveedores.php' ;
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}

function reportInvent(){

    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/report_invent.php' ;
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}