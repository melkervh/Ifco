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
        $sql = '	SELECT id_fact_nor, nombre_cli, fecha_fn
        FROM factura_normal
        INNER JOIN cliente USING (id_cliente)
        ORDER BY id_fact_nor ';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /* Método para buscar en el historial .................................................... */
    public function searchRows($value)
    {
        $sql = "SELECT id_fact_nor , nombre_cli, fecha_fn
        FROM factura_normal
        INNER JOIN cliente using (id_cliente)                                                
        WHERE nombre_cli ILIKE ?
        order by nombre_cli";
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
    
     /* Método para los productos de los reportes de la factura */
     public function readFactura(){
        $sql = 'SELECT id_fact_nor, vnta_dt, fecha_fn, numero_fact
                FROM factura_normal
                WHERE id_fact_nor = ?';
        $params = array($this->id_fact_nor);
        return Database::getRow($sql, $params);
    }  

    /* Método para los productos de los reportes de la factura */
    public function readAllProductos(){
        $sql = 'SELECT detalle_factura.id_detalle_fac, nombre_prodroducto, precio_u, precio_total, cantidad_com
        FROM detalle_factura
        INNER JOIN factura_normal
        ON detalle_factura.id_fact_nor = factura_normal.id_fact_nor
        INNER JOIN producto
        ON detalle_factura.id_producto = producto.id_producto
                WHERE factura_normal.id_fact_nor = ?';
        $params = array($this->id_fact_nor);
        return Database::getRows($sql, $params);
    }
}