<?php
/* Clase para manejar la tabla tipo_producto de la base de datos. */
/* Es clase hija de Validator. */

class TipoProducto extends Validator{

    // Declaración de atributos (propiedades).
    private $id = null;
    private $tipo = null;

    /* Métodos para validar y asignar valores de los atributos. */

    public function setId($value){

        if($this->validateNaturalNumber($value)){
            $this->id = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setTipo($value){

        if($this->validateAlphanumeric($value, 1, 100)){
            $this->tipo = $value;
            return true;
        }else{
            return false;
        }
    }

    /* Métodos para obtener valores de los atributos. */

    public function getId(){
        return $this->id;
    }

    public function getTipo(){
        return $this->tipo;
    }

    /* Métodos para tipo ................................................................. */

    /* Método para realizar readAll, para cargar el combobox del Estado del usuario */
    public function readAll(){
        $sql = 'SELECT id_tipo_prod, tipo_producto
                FROM tipo_producto';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /* Método para buscar SCRUD (search) ................................................................ */
    public function searchRows($value){
        $sql = 'SELECT id_tipo_prod, tipo_producto
                FROM tipo_producto
                WHERE tipo_producto ILIKE ? 
                ORDER BY tipo_producto';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    /* Método para crear SCRUD (create) ................................................................. */
    public function createRow(){
        $sql = 'INSERT INTO tipo_producto (tipo_producto)
                VALUES(?)';
        $params = array($this->tipo);
        return Database::executeRow($sql, $params);
    }
    
    /* Método para corroborar si un dato es existente y para el model de editar .............-........... */
    public function readOne(){
        $sql = 'SELECT id_tipo_prod, tipo_producto
                FROM tipo_producto
                WHERE id_tipo_prod = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    
    /* Método para actualizar SCRUD (update) ............................................................ */
    public function updateRow(){
        $sql = 'UPDATE tipo_producto
                SET tipo_producto = ?
                WHERE id_tipo_prod = ?';
        $params = array($this->tipo, $this->id);
        return Database::executeRow($sql, $params);
    }

    /* Método para eliminar SCRUD (delete) .............................................................. */
    public function deleteRow(){
        $sql = 'DELETE FROM tipo_producto
                WHERE id_tipo_prod = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }   
}