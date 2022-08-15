<?php
/* Clase para manejar la productos de la base de datos. */
/* Es clase hija de Validator. */

class Detalles extends Validator{
    private $id_produto= null;
    private $precio_u= null;
    private $precio_total= null;
    private $cantidad_com= null;
    private $nombre_com= null;
    private $id_fact_nor= null;

    public function setIdProducto($value)
   {
       if ($this->validateNaturalNumber($value)) {
           $this->id_producto= $value;
           return true;
       } else {
           return false;
       }
   }
   public function setPrecioU($value)
   {
       if ($this->validateAlphanumeric($value, 1, 50)) {
           $this->precio_u = $value;
           return true;
       } else {
           return false;
       }
   }
   public function setPrecioTotal($value)
   {
       if ($this->validateAlphanumeric($value, 1, 50)) {
           $this->precio_total = $value;
           return true;
       } else {
           return false;
       }
   }
   public function setCantidadCom($value)
   {
       if ($this->validateAlphanumeric($value, 1, 50)) {
           $this->cantidad_com = $value;
           return true;
       } else {
           return false;
       }
   }
    public function setnombre_com($value)
    {
        if ($this->validateString($value, 1, 50)) {
            $this->nombre_com= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setfact_nor($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_fact_nor= $value;
            return true;
        } else {
            return false;
        }
    }
    
    public function createdetalle()
    {
    $sql = 'INSERT INTO detalle_factura(
        id_producto, nombre_com, precio_u, precio_total, cantidad_com, id_fact_nor)
       VALUES (?, ?, ?, ?, ?,?)';
    $params = array($this->id_producto, $this->nombre_com, $this->precio_u, $this->precio_total, $this->cantidad_com, $this->id_fact_nor);
    return Database::executeRow($sql, $params);
    }

    /* Método para cargar productos por fechas reciente ...................................... */
    public function readAllFechas()
    {
        $sql = 'SELECT nombre_prodroducto, cantidad_prodroducto, descripcion_producto, precio_unidad
               FROM producto 
            ORDER BY nombre_prodroducto DESC limit 10';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /* Método para cargar productos por fechas cortas ........................................ */
    public function readAllFechaCorta()
    {
        $sql = 'SELECT nombre_prodroducto, cantidad_prodroducto, descripcion_producto, precio_unidad
        FROM producto 
     ORDER BY nombre_prodroducto DESC limit 5';
        $params = null;
        return Database::getRows($sql, $params);
    }
    
    
}