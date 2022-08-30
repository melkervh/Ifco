<?php
// Se verifica si existe el parámetro id en la url, de lo contrario se direcciona a la página web de origen.
    require('../helpers/dashboard_report.php');
    require('../models/productos.php');

$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Listado de inventarios');
// Se instancia el módelo de Descuento para procesar los datos.
$inventario = new Productos;

    // Se verifica si existen registros (clientes) para mostrar.
    if ($datainventario = $inventario->reporInvent()) {
                    
        // Se establece un color de relleno para los encabezados.
        $pdf->setFillColor(40, 75, 99);
        // Se establece la fuente para los encabezados.
        $pdf->setFont('Arial', 'B', 11);
        $pdf->SetTextColor(255,255,255);

        // Se imprimen las celdas con los encabezados.
        $pdf->cell(40, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
        $pdf->cell(35, 10, utf8_decode('Cantidad'), 1, 0, 'C', 1);
        $pdf->cell(35, 10, utf8_decode('Categoria'), 1, 0, 'C', 1);
        $pdf->cell(35, 10, utf8_decode('Marca'), 1, 0, 'C', 1);
        $pdf->cell(25, 10, utf8_decode('Estado'), 1, 0, 'C', 1);
        $pdf->cell(20, 10, utf8_decode('precio'), 1, 1, 'C', 1);

        // Se establece la fuente para los datos de los clientes.
            $pdf->setFont('Arial', '', 11);
            $pdf->SetTextColor(0, 0, 0);            

        // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
        foreach ($datainventario as $rowInventario) {
            $pdf->cell(40, 10, utf8_decode($rowInventario['nombre_prodroducto']), 1, 0, 'C');
            $pdf->cell(35, 10, utf8_decode($rowInventario['cantidad_prodroducto']), 1, 0, 'C');
            $pdf->cell(35, 10, utf8_decode($rowInventario['tipo_producto']), 1, 0, 'C');
            $pdf->cell(35, 10, utf8_decode($rowInventario['marca']), 1, 0, 'C');
            $pdf->cell(25, 10, utf8_decode($rowInventario['estado_producto']), 1, 0, 'C');
            $pdf->cell(20, 10, utf8_decode($rowInventario['precio_unidad']), 1, 1, 'C');
        }
    } else {
        $pdf->cell(0, 10, utf8_decode('No hay productos ingresados'), 1, 1);
    }
    // Se envía el documento al navegador y se llama al método footer()
    $pdf->output('I', 'inventario de productos.pdf');