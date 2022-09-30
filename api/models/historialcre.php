<?php
/* Clase para manejar el historial de la base de datos. */
/* Es clase hija de Validator. */

class Historialcre extends Validator
{
    private $id_fiscal  = null ;

    public function setidPedido($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_fiscal = $value;
            return true;
        } else {
            return false;
        }
    }
    public function getidPedido()
    {
        return $this->id_fiscal;
    }
    /* Método para cargar el historial ....................................................... */
    public function readAll()
    {
        $sql = 'SELECT id_fiscal, nombre_cli, fecha_credito
        FROM credito_fiscal
        INNER JOIN cliente USING (id_cliente)
        ORDER BY id_fiscal ';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /* Método para buscar en el historial .................................................... */
    public function searchRows($value)
    {
        $sql = "SELECT id_fiscal, nombre_cli, fecha_credito
        FROM credito_fiscal
        INNER JOIN cliente using (id_cliente)                                                 
        WHERE nombre_cli ILIKE ?
        order by nombre_cli";
        $params = array("%$value%");
        Database::getRows($sql, $params);
        return Database::getRows($sql, $params);
    }
    public function readAlld()
    {
        $sql = 'SELECT id_detallecre,nombre_prodroducto, cantidad_cre, precio_u, total,detalle_credito.cantidad_cre
        FROM detalle_credito
     inner join producto on detalle_credito.id_producto = producto.id_producto
     where id_detallecre = ?';
        $params = array($this->id_fact_nor);
        return Database::getRows($sql, $params);
    }

     /* Método para los productos de los reportes de la factura */
     public function readFacturaC(){
        $sql = 'SELECT id_fiscal,fecha_credito, numero_credi,nombre_cli
        FROM credito_fiscal
        inner join cliente using (id_cliente)
        where id_fiscal =?  ';
       $params = array($this->id_fiscal);
        return Database::getRow($sql, $params);
    }  

    /* Método para los productos de los reportes de la factura */
    public function readAllProductosC(){
        $sql = '	SELECT detalle_credito, nombre_prodroducto, precio_u, total, cantidad_cre
        FROM detalle_credito
		inner join credito_fiscal using (id_fiscal)
		inner join producto using (id_producto)
		  where id_fiscal =?';
      $params = array($this->id_fiscal);
        return Database::getRows($sql, $params);
    }
    
}