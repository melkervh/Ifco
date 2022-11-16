<?php
class Proveedores extends Validator
{
    //funcion para mostrar datos en la tabla
    private $id_proveedor = null;
    private $nombre_prv= null;
    private $contacto= null;

    public function setIdProveedor($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_proveedor = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombrePrv($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->nombre_prv = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setcontacto($value)
    {
        if ($this->validateEmail($value)) {
            $this->contacto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function readAll()
    {
        $sql = 'SELECT id_proveedor, nombre_prv, contacto
        FROM proveedor';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO proveedor(
            nombre_prv, contacto)
           VALUES ( ?, ?)';
        $params = array($this->nombre_prv, $this->contacto);
        return Database::executeRow($sql, $params);
    }

    //Busqueda de Usuario//
    public function searchRows($value)
    {
        $sql = 'SELECT id_proveedor, nombre_prv, contacto
        FROM proveedor
       WHERE nombre_prv ILIKE ?
              ORDER BY nombre_pvr';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    public function readOne()
    {
        $sql = 'SELECT id_proveedor, nombre_prv, contacto
                FROM proveedor
                WHERE id_proveedor = ?';
        $params = array($this->id_proveedor);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE proveedor
                SET  nombre_prv=?, contacto=?
                WHERE id_proveedor = ?';
        $params = array($this->nombre_prv, $this->contacto,);
        return Database::executeRow($sql, $params);
    }

    //borrar un Usuario//
    public function deleteRow()
    {
        $sql = 'DELETE FROM proveedor
                WHERE id_proveedor = ?';
        $params = array($this->id_proveedor);
        return Database::executeRow($sql, $params);
    }

}