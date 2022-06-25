<?php
class createcredito extends Validator
{
    /* valores del cliente*/ 
    private $id_cliente  = null;
    private $nombre_cliente = null;
    private $apellido_cliente = null;
    private $DUI_cli = null;
    private $Departamento_clien = null;
    private $municipio = null;
    /*valores del credito*/
    private $id_fiscal  = null;
    private $nota_mision  = null;
    private $condicion_pago  = null;
    private $giro = null;
    private $via_a_cta_de = null;
    private $fecha_credito = null;
    private $numero_credi= null;
    /*valores de el detalle*/ 
    private $id_detallecre = null;
    private $id_producto = null;
    private $nombre_cre = null;
    private $cantidad_cre = null;
    private $precio_u = null;
    private $total = null;

    /* set del cliente */
    public function setIdclienteCre($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_cliente= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setNombrescliente($value)
    {
        if ($this->validateString($value, 1, 50)) {
            $this->nombre_cliente= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setApellidoscliente($value)
    {
        if ($this->validateString($value, 1, 50)) {
            $this->nombre_cliente= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setDUI($value)
    {
        if ($this->validateDUI($value)) {
            $this->DUI_cliente = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setDepartamentoClie($value)
    {
        if ($this->validateString($value, 1, 50)) {
            $this->Departamento_clien= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setMunicipio($value)
    {
        if ($this->validateString($value, 1, 50)) {
            $this->municipio= $value;
            return true;
        } else {
            return false;
        }
    }
     /* set del credito */
    public function setIdCredito($value)
     {
         if ($this->validateNaturalNumber($value)) {
             $this->id_fiscal = $value;
             return true;
         } else {
             return false;
         }
     }
    public function setNotamision($value)
     {
         if ($this->validateString($value, 1, 50)) {
             $this->nota_mision= $value;
             return true;
         } else {
             return false;
         }
     }
    public function setcondicion($value)
     {
         if ($this->validateString($value, 1, 50)) {
             $this->condicion_pago= $value;
             return true;
         } else {
             return false;
         }
     }
     public function setgiro($value)
     {
         if ($this->validateString($value, 1, 50)) {
             $this->giro= $value;
             return true;
         } else {
             return false;
         }
     }
     public function setVia($value)
     {
         if ($this->validateString($value, 1, 50)) {
             $this->via_a_cta_de= $value;
             return true;
         } else {
             return false;
         }
     }
     public function setfechacre($value)
    {
        if ($this->validateDate($value)) {
            $this->fecha_credito = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setnumerocre($value)
    {
        if ($this->validateString($value)) {
            $this->fecha_credito = $value;
            return true;
        } else {
            return false;
        }
    }
    /*set de el detalle*/
    public function setIdDetallecre($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->$id_detallecre = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIdProductoCre($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->$id_producto = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setNombrCre($value)
    {
        if ($this->validateString($value, 1, 50)) {
            $this->nombre_cre= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setCantidadCre($value)
    {
        if ($this->validateString($value, 1, 50)) {
            $this->cantidad_cre= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setPrecioUni($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->precio_u= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setTotal($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->total = $value;
            return true;
        } else {
            return false;
        }
    }

    /* metodo de creacion de el cliente en el credito fiscal*/
    public function createClienteCredito()
    {
    $sql = 'INSERT INTO cliente(
    nombre_cli, apellido_cli, "DUI", departamento, municipio)
    VALUES ( ?, ?, ?, ?, ?)';
    $params = array($this->nombre_cliente, $this->apellido_cliente, $this->DUI_cli,$this->Departamento_clien,$this->municipio );
    return Database::executeRow($sql, $params);
    }

    /* metodo de creacion de credito fiscal*/
    public function createCredito()
    {
    $sql = 'INSERT INTO credito_fiscal(
        nota_mision, condicion_pago, giro, via_a_cta_de, fecha_credito)
       VALUES ( ?, ?, ?, ?, ?);';
    $params = array($this->nota_mision,$this->condicion_pago,$this->giro,$this->via_a_cta_de,$this->fecha_credito);
    return Database::executeRow($sql, $params);
    }
    /* metodo de creacion de credito fiscal*/
    public function createDetalleCre()
    {
    $sql = 'INSERT INTO detalle_credito(
        id_producto, nombre_cre, cantidad_cre, precio_u, total)
        VALUES ( ?, ?, ?, ?, ?);';
    $params = array($this->id_producto,$this->nombre_cre,$this->cantidad_cre,$this->precio_u,$this->total);
    return Database::executeRow($sql, $params);
    }
}