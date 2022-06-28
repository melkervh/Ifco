<?php
class createfactura extends Validator{
    /* valores para el cliente*/
    private $id_cliente  = null;
    private $nombre_cli  = null;
    private $apellido_cli  = null;
    private $DUI  = null;
    private $Departamento  = null;
  /* valores para la factura*/
    private $venta= null;
    private $fecha= null;
    private $Numero= null;
        /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdCliente($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_cliente= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setNombrecliente($value)
    {
        if ($this->validateString($value, 1, 50)) {
            $this->nombre_cli= $value;
            return true;
        } else {
            return false;
        }
    }
     public function setApellidocliente($value)
    {
        if ($this->validateString($value, 1, 50)) {
            $this->apellido_cli = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setdui($value)
    {
        if ($this->validateDUI($value)) {
            $this->DUI = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setDepartamento($value)
    {
        if ($this->validateString($value, 1, 50)) {
            $this->Departamento= $value;
            return true;
        } else {
            return false;
        }
    }
   /**/
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
        if ($this->validateDate($value)) {

            $this->fecha = $value;

            return true;

        } else {

            return false;

        }

    }
   
     /*funcion para insertar los datos en las tabla de detalle */

     /*c funcion para agregar un cliente */
    public function createCliente()
    {
    $sql = 'INSERT INTO cliente(
    nombre_cli, apellido_cli, "DUI",departamento)
    VALUES ( ?, ?, ?,?)';
    $params = array($this->nombre_cli, $this->apellido_cli, $this->DUI,$this->Departamento );
    return Database::executeRow($sql, $params);
    }

        /*funcion para incertar datos en la tabla factura_normal */
    public function createfactura()
    {
    $sql = 'INSERT INTO factura_normal(
    vnta_dt, fecha_fn)
    VALUES ( ?, ?)';
    $params = array($this->venta, $this->fecha);
    return Database::executeRow($sql, $params);
    }

}