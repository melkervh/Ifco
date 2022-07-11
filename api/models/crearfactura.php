<?php
class createfactura extends Validator{
    private $id_cliente  = null;
    private $nombre_cli  = null;
    private $apellido_cli  = null;
    private $DUI  = null;
    private $Departamento  = null;
    private $id_detalle= null;
    private $id_produto= null;
    private $precio_u= null;
    private $precio_total= null;
    private $cantidad_com= null;
    private $id_factura= null;
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
   public function setCantidadCom($value)
   {
       if ($this->validateAlphanumeric($value, 1, 50)) {
           $this->cantidad_com = $value;
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
    public function setnumero($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->numero= $value;
            return true;
        } else {
            return false;
        }
    }
   
     /*funcion para insertar los datos en las tabla de detalle */
    public function createDetalle()
    {
    $sql = 'INSERT INTO detalle_factura(
    id_producto, precio_u, precio_total,cantidad_com)
    VALUES ( ?, ?, ?, ?)';
    $params = array($this->id_producto, $this->precio_u, $this->precio_total, $this->cantidad_com);
    return Database::executeRow($sql, $params);
    }

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