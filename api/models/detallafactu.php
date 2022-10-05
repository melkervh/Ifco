<?php

class DetalleFactu extends Validator
{
    private $id_detalle= null;
    private $id_produto= null;
    private $precio_u= null;
    private $precio_total= null;
    private $cantidad= null;
     /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdDetalle($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_detalle= $value;
            return true;
        } else {
            return false;
        }
    }
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
    public function setCantidad($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }
    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdDetalle()
    {
        return $this->id_detalle;
    }
    public function getIdProducto()
    {
        return $this->id_producto;
    }
    public function getIdPrecioU()
    {
        return $this->precio_u;
    }
    public function getIdPrecioTotal()
    {
        return $this->precio_total;
    }
    public function getCantidad()
    {
        return $this->cantidad;
    }
    /*funcion para insertar los datos en las tabla de detalle */
    public function createDetalle()
           {
    $sql = 'INSERT INTO detalle_factura(
        id_producto, precio_u, precio_total, cantidad_com)
       VALUES ( ?, ?, ?, ?)';
    $params = array($this->id_producto, $this->precio_u, $this->precio_total, $this->cantidad);
    return Database::executeRow($sql, $params);
      }
}