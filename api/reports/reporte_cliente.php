<?php
require('../helpers/dashboard_report.php');
require('../models/clientes.php');

$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Listado de clientes');
// Se instancia el módelo de Descuento para procesar los datos.
$cliente = new Clientes;

    // Se verifica si existen registros (clientes) para mostrar.
    if ($dataClientes = $cliente->readAll()) {
                    
        // Se establece un color de relleno para los encabezados.
        $pdf->setFillColor(40, 75, 99);
        // Se establece la fuente para los encabezados.
        $pdf->setFont('Arial', 'B', 11);
        $pdf->SetTextColor(255,255,255);

        // Se imprimen las celdas con los encabezados.
            $pdf->cell(60, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
            $pdf->cell(40, 10, utf8_decode('Télefono'), 1, 0, 'C', 1);
            $pdf->cell(30, 10, utf8_decode('DUI'), 1, 0, 'C', 1);
            $pdf->cell(55, 10, utf8_decode('Departamento'), 1, 1, 'C', 1);

        // Se establece la fuente para los datos de los clientes.
            $pdf->setFont('Arial', '', 11);
            $pdf->SetTextColor(0, 0, 0);            

        // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
        foreach ($dataClientes as $rowClientes) {
            $pdf->cell(60, 10, utf8_decode($rowClientes['nombre_cli']).' '.utf8_decode($rowClientes['apellido_cli']), 1, 0, 'C');
            $pdf->cell(40, 10, utf8_decode($rowClientes['telefono']), 1, 0, 'C');
            $pdf->cell(30, 10, utf8_decode($rowClientes['DUI']), 1, 0, 'C');
            $pdf->cell(55, 10, utf8_decode($rowClientes['departamento']), 1, 1, 'C');
        }
    } else {
        $pdf->cell(0, 10, utf8_decode('No hay clientes registrados'), 1, 1);
    }
    // Se envía el documento al navegador y se llama al método footer()
    $pdf->output('I', 'Listado de clientes.pdf');