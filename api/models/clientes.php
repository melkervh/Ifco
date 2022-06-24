<?php
/*
*	Clase para manejar la tabla de clientes en  la base de datos.
*   Es clase hija de Validator.
*/
class Clientes extends Validator
{
    private $id_cliente  = null;
    private $nombre_cli  = null;
    private $apellido_cli  = null;
    private $DUI  = null;
    private $telefono  = null;
    private $Departamento  = null;
    private $municipio  = null;
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
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->nombre_cli= $value;
            return true;
        } else {
            return false;
        }
    }
     public function setApellidocliente($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->apellido_cli = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setdui($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->DUI = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setTelefono($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->telefono= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setDepartamento($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->Departamento= $value;
            return true;
        } else {
            return false;
        }
    }
    public function setMunicipio($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->municipio= $value;
            return true;
        } else {
            return false;
        }
    }
    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdCliente()
    {
        return $this->id_cliente;
    }
    public function getNombreCliente()
    {
        return $this->nombre_cli;
    }
    public function getApellidoCliente()
    {
        return $this->apellido_cli;
    }
    public function getdui()
    {
        return $this->DUI;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getDepartamento()
    {
        return $this->departamento;
    }
    public function getMunicipio()
    {
        return $this->municipio;
    }
/*c funcion para agregar un cliente */
public function createRow()
{
    $sql = 'INSERT INTO cliente(
        nombre_cli, apellido_cli, "DUI")
       VALUES ( ?, ?, ?);';
    $params = array($this->nombre_cli, $this->apellido_cli, $this->DUI ,);
    return Database::executeRow($sql, $params);
}
    
}