<?php
/* Clase para manejar el historial de la base de datos. */
/* Es clase hija de Validator. */

class Historial extends Validator
{
    private $id_fact_nor  = null ;

    public function setidPedido($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_fact_nor = $value;
            return true;
        } else {
            return false;
        }
    }
    public function getidPedido()
    {
        return $this->id_fact_nor;
    }
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
        FROM factura_normal
        INNER JOIN cliente 
        ON id_cliente = id_cliente                                                
        WHERE nombre_cli ILIKE ?';
        $params = array("%$value%");
        Database::getRows($sql, $params);
        return Database::getRows($sql, $params);
    }
    public function readAlld()
    {
        $sql = 'SELECT id_detalle_fac, nombre_prodroducto, descripcion_producto, precio_u, detalle_factura.cantidad_com
           FROM detalle_factura
        inner join producto on detalle_factura.id_producto = producto.id_producto
        where id_fact_nor =?';
        $params = array($this->id_fact_nor);
        return Database::getRows($sql, $params);
    }
    
}