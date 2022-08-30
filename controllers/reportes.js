//Este JS es solo para los reportes que son de tipo normal es decir no necesitan de un parametro

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
//Se inicia el codigo para la funcion del reporte para los clientes
//Esta misma funcion nos permite hacer funcionar el boton para abrir el reporte.
function reportClientes(){

    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/reporte_cliente.php' ;
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}

//Se inicia el codigo para la funcion del reporte para los proveedores
//Esta misma funcion nos permite hacer funcionar el boton para abrir el reporte.
function reportProveedores(){

    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/reporte_proveedores.php' ;
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}
//Se inicia el codigo para la funcion del reporte para los inventarios
//Esta misma funcion nos permite hacer funcionar el boton para abrir el reporte.
function reportInvent(){

    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/report_invent.php' ;
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}