//Se inicia el codigo para la funcion del reporte para los productos y sus marcas.
//Esta misma funcion nos permite hacer funcionar el boton para abrir el reporte.
function openReporteProduc() {
    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/reporte_producto.php';
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}
//Se inicia el codigo para la funcion del reporte para los clientes y sus respectivos departamento.
//Esta misma funcion nos permite hacer funcionar el boton para abrir el reporte.
function openReporteDepar() {
    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/reporte_deparmento.php';
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}

