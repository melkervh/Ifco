<?php
class createcredito extends Validator
{
    private $id_cliente  = null;
    private $nombre_cliente = null;
    private $apellido_cliente = null;
    private $DUI_cli = null;
    private $Departamento_clien = null;
    private $municipio = null;


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

    /* metodo de creacion de el cliente en el credito fiscal*/
      public function createClienteCredito()
      {
      $sql = 'INSERT INTO cliente(
        nombre_cli, apellido_cli, "DUI", departamento, municipio)
        VALUES ( ?, ?, ?, ?, ?)';
      $params = array($this->nombre_cliente, $this->apellido_cliente, $this->DUI_cli,$this->Departamento_clien,$this->municipio );
      return Database::executeRow($sql, $params);
      }
}