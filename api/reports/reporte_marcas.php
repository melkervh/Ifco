<?php
// Se verifica si existe el parámetro id en la url, de lo contrario se direcciona a la página web de origen.
if (isset($_GET['id_marca'])) {
    require('../helpers/dashboard_report.php');
    require('../models/marcas.php');
    require('../models/productos.php');

    // Se instancia el módelo Marca para procesar los datos.
    $marca = new Marcas;

    // Se verifica si el parámetro es un valor correcto, de lo contrario se direcciona a la página web de origen.
    if ($marca->setId($_GET['id_marca'])) {
        // Se verifica si la marca del parametro existe, de lo contrario se direcciona a la página web de origen.
        if ($rowMarca = $marca->readOne()) {
            // Se instancia la clase para crear el reporte.
            $pdf = new Report;
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos de la Marca: '.$rowMarca['marca']);

            // Se instancia el módelo Productos para procesar los datos.
            $producto = new Productos;
            if ($producto->setMarca($rowMarca['id_marca'])) {
                // Se verifica si existen registros (productos) para mostrar, de lo contrario se imprime un mensaje.
                if ($dataProductos = $producto->marcaProduc()) {
                    // Se establece un color de relleno para los encabezados.
                    $pdf->setFillColor(255);
                    // Se establece la fuente para los encabezados.
                    $pdf->setFont('Times', 'B', 11);
                    // Se imprimen las celdas con los encabezados.
                    $pdf->cell(30, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
                    $pdf->cell(30, 10, utf8_decode('Cantidad'), 1, 0, 'C', 1);
                    $pdf->cell(120, 10, utf8_decode('Descripcion'), 1, 1, 'C', 1);
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
                    foreach ($dataProductos as $rowProducto) {
                        // Se imprimen las celdas con los datos de los productos.
                        $pdf->cell(30, 10, utf8_decode($rowProducto['nombre_prodroducto']), 1, 0);
                        $pdf->cell(30, 10, $rowProducto['cantidad_prodroducto'], 1, 0);
                        $pdf->cell(120, 10, $rowProducto['descripcion_producto'], 1, 1);
                    }
                } else {
                    $pdf->cell(0, 10, utf8_decode('No hay productos para esta marca'), 1, 1);
                }
                // Se envía el documento al navegador y se llama al método footer()
                $pdf->output('I', 'cateoria.pdf');
            } else {
                //header('location: ../../../views/dashboard/Categoria.html');
            }
        } else {
            //header('location: ../../../views/dashboard/Categoria.html');
        }
    } else {
        //header('location: ../../../views/dashboard/Categoria.html');
    }
} else {
    //header('location: ../../../views/dashboard/Categoria.html');
}
?>