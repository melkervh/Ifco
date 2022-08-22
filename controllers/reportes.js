
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
