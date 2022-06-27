<?php
/* Clase para manejar la productos de la base de datos. */
/* Es clase hija de Validator. */

class Productos extends Validator{


    /* Método para cargar productos por fechas reciente ...................................... */
    public function readAllFechas()
    {
        $sql = 'SELECT nombre_prodroducto, fecha_fn, precio_u, cantidad_com
                FROM producto
                INNER JOIN detalle_factura 
                ON detalle_factura.id_producto = producto.id_producto
                INNER JOIN factura
                ON factura.id_detalle_fac = detalle_factura.id_detalle_fac
                INNER JOIN factura_normal
                ON factura.id_fact_nor = factura_normal.id_fact_nor
                ORDER BY fecha_fn DESC limit 10';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /* Método para cargar productos por fechas cortas ........................................ */
    public function readAllFechaCorta()
    {
        $sql = 'SELECT nombre_prodroducto, fecha_fn, precio_u, cantidad_com
                FROM producto
                INNER JOIN detalle_factura 
                ON detalle_factura.id_producto = producto.id_producto
                INNER JOIN factura
                ON factura.id_detalle_fac = detalle_factura.id_detalle_fac
                INNER JOIN factura_normal
                ON factura.id_fact_nor = factura_normal.id_fact_nor
                ORDER BY fecha_fn DESC limit 5';
        $params = null;
        return Database::getRows($sql, $params);
    }
    
    
}