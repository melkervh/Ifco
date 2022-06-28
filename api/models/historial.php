<?php
/* Clase para manejar el historial de la base de datos. */
/* Es clase hija de Validator. */

class Historial extends Validator{

    /* Método para cargar el historial ....................................................... */
    public function readAll()
    {
        $sql = 'SELECT id_fact_nor, nombre_cli, fecha_fn
        FROM factura_normal
        INNER JOIN cliente c
        ON id_cliente = c.id_cliente
        ORDER BY fecha_fn DESC';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /* Método para buscar en el historial .................................................... */
    public function searchRows($value)
    {
        $sql = 'SELECT id_fact_nor , nombre_cli, fecha_fn
                FROM id_fact_nor
                INNER JOIN cliente c
                ON id_cliente = c.id_cliente
                WHERE nombre_cli ILIKE ?';
        $params = array("%$value%");
        Database::getRows($sql, $params);
        return Database::getRows($sql, $params);
    }
    
    
}