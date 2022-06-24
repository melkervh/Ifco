<?php
/*
*	Clase para manejar la tabla de factura en  la base de datos.
*   Es clase hija de Validator.
*/
class FacturaNormal extends Validator
{
    private $id_factura= null;
    private $venta= null;
    private $fecha= null;
    private $Numero= null;
      /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdFactura($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_factura= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setventa($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->venta= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setfecha($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->fecha= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setnumero($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->numero= $value;
            return true;
        } else {
            return false;
        }
    }
     /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdFactura()
    {
        return $this->id_factura;
    }
    public function getventa()
    {
        return $this->venta;
    }
    public function getfecha()
    {
        return $this->fecha;
    }
    public function getnumero()
    {
        return $this->numero;
    }
    /*funcion para incertar datos en la tabla factura_normal */
    public function createfactura()
           {
    $sql = 'INSERT INTO factura_normal(
        vnta_dt, fecha_fn)
       VALUES ( ?, ?)';
    $params = array($this->venta, $this->fecha, $this->numero,);
    return Database::executeRow($sql, $params);
      }
}