<?php
// Se verifica si existe el parámetro id en la url, de lo contrario se direcciona a la página web de origen.
if (isset($_GET['id'])) {
    require('../helpers/dashboard_report.php');
    require('../models/historial.php');

    // Se instancia el módelo Pedidos para obtener los datos.
    $factura = new Historial;

    // Se verifica si el parámetro es un valor correcto, de lo contrario se direcciona a la página web de origen.
    if ($factura->setidPedido($_GET['id'])) {
        // Se verifica si la categoría del parametro existe, de lo contrario se direcciona a la página web de origen.
        if ($rowHistorial = $factura->readFactura()) {

            // Se instancia la clase para crear el reporte.
            $pdf = new Report;
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Factura');

            // Se establece un color de relleno para los encabezados.
            $pdf->setFillColor(40, 75, 99);
            // Se establece la fuente para los encabezados.
            $pdf->setFont('Arial', 'B', 11);
            $pdf->SetTextColor(255,255,255);

            // Se imprimen las celdas con los encabezados.
            $pdf->cell(45, 10, utf8_decode('N° de factura'), 1, 0, 'C', 1);
            $pdf->cell(95, 10, utf8_decode('Nombre de la cuenta a asignar la venta'), 1, 0, 'C', 1);
            $pdf->cell(45, 10, utf8_decode('Fecha'), 1, 1, 'C', 1);

            // Se establece la fuente para los datos de la factura.
            $pdf->setFont('Arial', '', 11);
            $pdf->SetTextColor(0, 0, 0);            

            // Celdas para la formación de la factura
            $pdf->cell(45, 10, $rowHistorial['numero_fact'], 1, 0, 'C');
            $pdf->cell(95, 10, $rowHistorial['vnta_dt'], 1, 0, 'C');
            $pdf->cell(45, 10, $rowHistorial['fecha_fn'], 1, 1, 'C');

            // Salto de linea
            $pdf->Ln(10);


            if ($factura->setidPedido($rowHistorial['id_fact_nor'])) {
                // Se verifica si existen registros (productos) para mostrar, de lo contrario se imprime un mensaje.
                if ($dataHistorial = $factura->readAllProductos()) {

                    // Se establece un color de relleno para los encabezados.
                    $pdf->setFillColor(40, 75, 99);
                    // Se establece la fuente para los encabezados.
                    $pdf->setFont('Arial', 'B', 11);
                    $pdf->SetTextColor(255,255,255);

                    // Se imprimen las celdas con los encabezados.
                    $pdf->cell(185, 10, utf8_decode('Articulos'), 1, 1, 'C', 1);
                    $pdf->cell(60, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
                    $pdf->cell(35, 10, utf8_decode('Cantidad'), 1, 0, 'C', 1);
                    $pdf->cell(45, 10, utf8_decode('Precio unitario ($US)'), 1, 0, 'C', 1);
                    $pdf->cell(45, 10, utf8_decode('SubTotal ($US)'), 1, 1, 'C', 1);

                    // Se establece la fuente para los datos de la factura.
                    $pdf->setFont('Arial', '', 11);
                    $pdf->SetTextColor(0, 0, 0);    
                    // Variable para el total 
                    $total = 0;
                    // Se recorren los registros ($dataDetallePedido) fila por fila ($rowDetallePedido).
                    foreach ($dataHistorial as $rowHistorial) {
                        // Se imprimen las celdas con los datos de los productos.
                        $pdf->cell(60, 10, $rowHistorial['nombre_prodroducto'], 1, 0, 'C');
                        $pdf->cell(35, 10, $rowHistorial['cantidad_com'], 1, 0, 'C');
                        $pdf->cell(45, 10, $rowHistorial['precio_u'], 1, 0, 'C');
                        $pdf->cell(45, 10, $rowHistorial['precio_total'], 1, 1, 'C');
                        $total += ($rowHistorial['precio_u'] * $rowHistorial['cantidad_com']);
                    }
                    $pdf->SetTextColor(255,255,255);
                    $pdf->cell(140, 10, utf8_decode('Total: '), 1, 0, 'R', 1);
                    $pdf->SetTextColor(0,0,0);
                    $pdf->cell(45, 10, '$ '.$total, 1, 1, 'C',);
                } else {
                    $pdf->cell(0, 10, utf8_decode('No hay productos registrados'), 1, 1);
                }        
            } else {
                header('location: ../../../views/historial.html');
            }    

            // Se envía el documento al navegador y se llama al método footer()
            $pdf->output('I', 'Factura normal.pdf');

        } else {
            header('location: ../../views/historial.html');
        }
    } else {
        header('location: ../../views/historial.html');
    }
} else {
    header('location:   ../../views/historial.html');
}


