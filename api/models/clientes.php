<?php
/* Clase para manejar el historial de la base de datos. */
/* Es clase hija de Validator. */

class Clientes extends Validator
{
    private $id_cliente  = null;
    private $nombre_cli  = null;
    private $apellido_cli  = null;
    private $DUI  = null;
    private $telefono  = null; 

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
    public function setelefono($value)
    {
        if ($this->validateString($value, 1, 50)) {
            $this->telefono= $value;
            return true;
        } else {
            return false;
        }
    }
    /* Método para cargar el historial ....................................................... */
    public function readAll()
    {
        $sql = 'SELECT id_cliente,nombre_cli, apellido_cli, "DUI",telefono
        FROM cliente
        ORDER BY nombre_cli';
        $params = null;
        return Database::getRows($sql, $params);
    }
    public function ReporteCliente()
    {
        $sql = 'SELECT nombre_cli, apellido_cli,"DUI",telefono,departamento,municipio
        FROM cliente
        ORDER BY nombre_cli';
        $params = null;
        return Database::getRows($sql, $params);
    }
      /*Metodo para el llenado de la tabla para el reporte del departamento y municipio*/
      public function reporDepart()
      {
          $sql = 'SELECT nombre_cli, apellido_cli, departamento, municipio
          FROM cliente
          ORDER BY nombre_cli';
          $params = null;
          return Database::getRows($sql, $params);
      }
      public function searchRows($value)
      {
          $sql = 'SELECT id_cliente,nombre_cli,apellido_cli,"DUI",telefono
          FROM cliente
          WHERE nombre_cli ILIKE ? OR apellido_cli ILIKE ?
          ORDER BY nombre_cli';
          $params = array("%$value%", "%$value%");
          return Database::getRows($sql, $params);
      }
      public function readOne()
      {
          $sql = 'SELECT id_cliente,nombre_cli,apellido_cli,"DUI",telefono
                 FROM cliente
                  WHERE id_cliente = ?';
          $params = array($this->id_cliente);
          return Database::getRow($sql, $params);
      }
      public function updateRow()
    {
        $sql = 'UPDATE cliente
        SET id_cliente=?, nombre_cli=?, apellido_cli=?, "DUI"=?, telefono=?
        WHERE id_cliente = ?';
        $params = array($this->nombre_cli, $this->apellido_cli, $this->DUI, $this->telefono,$this->id_cliente);
        return Database::executeRow($sql, $params);
    }
    public function deleteRow()
    {
        $sql = 'DELETE FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        return Database::executeRow($sql, $params);
    }
}