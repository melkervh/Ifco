<?php
// Se verifica si existe el parámetro id en la url, de lo contrario se direcciona a la página web de origen.
if (isset($_GET['id'])) {
    require('../helpers/dashboard_report.php');
    require('../models/historialcre.php');

    // Se instancia el módelo Pedidos para obtener los datos.
    $facturaCre = new Historialcre;

    // Se verifica si el parámetro es un valor correcto, de lo contrario se direcciona a la página web de origen.
    if ($facturaCre->setidPedido($_GET['id'])) {
        // Se verifica si la categoría del parametro existe, de lo contrario se direcciona a la página web de origen.
        if ($rowHistorialcre = $facturaCre->readFacturaC()) {

            // Se instancia la clase para crear el reporte.
            $pdf = new Report;
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Lista de credito');

            // Se establece un color de relleno para los encabezados.
            $pdf->setFillColor(40, 75, 99);
            // Se establece la fuente para los encabezados.
            $pdf->setFont('Arial', 'B', 11);
            $pdf->SetTextColor(255,255,255);

            // Se imprimen las celdas con los encabezados.
            $pdf->cell(95, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
            $pdf->cell(45, 10, utf8_decode('N° de factura'), 1, 0, 'C', 1);
            $pdf->cell(45, 10, utf8_decode('Fecha'), 1, 1, 'C', 1);

            // Se establece la fuente para los datos de la factura.
            $pdf->setFont('Arial', '', 11);
            $pdf->SetTextColor(0, 0, 0);            

            // Celdas para la formación de la factura
            $pdf->cell(95, 10, $rowHistorialcre['nombre_cli'], 1, 0, 'C');
            $pdf->cell(45, 10, $rowHistorialcre['numero_credi'], 1, 0, 'C');
            $pdf->cell(45, 10, $rowHistorialcre['fecha_credito'], 1, 1, 'C');

            // Salto de linea
            $pdf->Ln(10);


            if ($facturaCre->setidPedido($rowHistorialcre['id_fiscal'])) {
                // Se verifica si existen registros (productos) para mostrar, de lo contrario se imprime un mensaje.
                if ($dataHistorialcre = $facturaCre->readAllProductosC()) {

                    // Se establece un color de relleno para los encabezados.
                    $pdf->setFillColor(40, 75, 99);
                    // Se establece la fuente para los encabezados.
                    $pdf->setFont('Arial', 'B', 11);
                    $pdf->SetTextColor(255,255,255);

                    // Se imprimen las celdas con los encabezados.
                    $pdf->cell(185, 10, utf8_decode('Productos'), 1, 1, 'C', 1);
                    $pdf->cell(60, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
                    $pdf->cell(35, 10, utf8_decode('Cantidad'), 1, 0, 'C', 1);
                    $pdf->cell(45, 10, utf8_decode('Precio unitario ($US)'), 1, 0, 'C', 1);
                    $pdf->cell(45, 10, utf8_decode('Total ($US)'), 1, 1, 'C', 1);

                    // Se establece la fuente para los datos de la factura.
                    $pdf->setFont('Arial', '', 11);
                    $pdf->SetTextColor(0, 0, 0);    

                    // Se recorren los registros ($dataDetallePedido) fila por fila ($rowDetallePedido).
                    foreach ($dataHistorialcre as $rowHistorialcre) {
                        
                        // Se imprimen las celdas con los datos de los productos.
                        $pdf->cell(60, 10, $rowHistorialcre['nombre_prodroducto'], 1, 0, 'C');
                        $pdf->cell(35, 10, $rowHistorialcre['cantidad_cre'], 1, 0, 'C');
                        $pdf->cell(45, 10, $rowHistorialcre['precio_u'], 1, 0, 'C');
                        $pdf->cell(45, 10, $rowHistorialcre['total'], 1, 1, 'C');
                    }

                } else {
                    $pdf->cell(0, 10, utf8_decode('No hay productos registrados'), 1, 1);
                }        
            } else {
                header('location: ../../../views/historialcre.html');
            }    

            // Se envía el documento al navegador y se llama al método footer()
            $pdf->output('I', 'Lista de credito.pdf');

        } else {
           header('location: ../../views/historialcre.html');
        }
    } else {
        header('location: ../../views/historialcre.html');
    }
} else {
    
    header('location:   ../../views/historialcre.html');
}
