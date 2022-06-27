<?php
/* Clase para manejar el historial de la base de datos. */
/* Es clase hija de Validator. */

class Historial extends Validator{

    /* Método para cargar el historial ....................................................... */
    public function readAll()
    {
        $sql = 'SELECT id_factura, nombre_cli, fecha_fn
                FROM factura f
                INNER JOIN factura_normal fn
                ON f.id_fact_nor = fn.id_fact_nor
                INNER JOIN cliente c
                ON f.id_cliente = c.id_cliente
                ORDER BY fecha_fn DESC';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /* Método para buscar en el historial .................................................... */
    public function searchRows()
    {
        $sql = 'SELECT id_factura, nombre_cli, fecha_fn
                FROM factura f
                INNER JOIN factura_normal fn
                ON f.id_fact_nor = fn.id_fact_nor
                INNER JOIN cliente c
                ON f.id_cliente = c.id_cliente
                WHERE nombre_cli ILIKE ?';
        $params = array("%$value%");
        Database::getRows($sql, $params);
        return Database::getRows($sql, $params);
    }
    
    
}