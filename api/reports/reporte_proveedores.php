<?php
require('../helpers/dashboard_report.php');
require('../models/proveedores.php');

$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Listado de proveedores');
// Se instancia el módelo de Descuento para procesar los datos.
$proveedor = new Proveedores;

    // Se verifica si existen registros (clientes) para mostrar.
    if ($dataProveedores = $proveedor->readAll()) {
                    
        // Se establece un color de relleno para los encabezados.
        $pdf->setFillColor(40, 75, 99);
        // Se establece la fuente para los encabezados.
        $pdf->setFont('Arial', 'B', 11);
        $pdf->SetTextColor(255,255,255);

        // Se imprimen las celdas con los encabezados.
            $pdf->cell(120, 10, utf8_decode('Nombre del proveedor'), 1, 0, 'C', 1);
            $pdf->cell(65, 10, utf8_decode('Contacto'), 1, 1, 'C', 1);

        // Se establece la fuente para los datos de los clientes.
            $pdf->setFont('Arial', '', 11);
            $pdf->SetTextColor(0, 0, 0);            

        // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
        foreach ($dataProveedores as $rowProveedores) {
            $pdf->cell(120, 10, utf8_decode($rowProveedores['nombre_prv']), 1, 0, 'C');
            $pdf->cell(65, 10, utf8_decode($rowProveedores['contacto']), 1, 1, 'C');
        }
    } else {
        $pdf->cell(0, 10, utf8_decode('No hay proveedores registrados'), 1, 1);
    }
    // Se envía el documento al navegador y se llama al método footer()
    $pdf->output('I', 'Listado de proveedores.pdf');