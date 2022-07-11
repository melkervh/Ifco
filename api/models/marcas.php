<?php
/* Clase para manejar la tabla marcas de la base de datos. */
/* Es clase hija de Validator. */

class Marcas extends Validator{

    // Declaración de atributos (propiedades).
    private $id = null;
    private $marcas = null;
    private $proveedor = null;
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

    public function setMarcas($value){

        if($this->validateAlphanumeric($value, 1, 100)){
            $this->marcas = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setProveedor($value){

        if($this->validateNaturalNumber($value)){
            $this->proveedor = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setTipo($value){

        if($this->validateNaturalNumber($value)){
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

    public function getMarcas(){
        return $this->marcas;
    }

    public function getProveedor(){
        return $this->proveedor;
    }

    public function getTipo(){
        return $this->tipo;
    }

    /* Métodos para marcas ................................................................. */

    /* Método para realizar readAll, para cargar el combobox del Estado del usuario */
    public function readAll(){
        $sql = 'SELECT id_marca, marca, nombre_prv, tipo_producto, marca.id_proveedor, marca.id_tipo_prod
                FROM marca
                INNER JOIN proveedor
                ON proveedor.id_proveedor = marca.id_proveedor
                INNER JOIN tipo_producto
                ON tipo_producto.id_tipo_prod = marca.id_tipo_prod';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /* Método para buscar SCRUD (search) ................................................................ */
    public function searchRows($value){
        $sql = 'SELECT id_marca, marca, nombre_prv, tipo_producto, marca.id_proveedor, marca.id_tipo_prod
                FROM marca
                INNER JOIN proveedor
                ON proveedor.id_proveedor = marca.id_proveedor
                INNER JOIN tipo_producto
                ON tipo_producto.id_tipo_prod = marca.id_tipo_prod
                WHERE marca ILIKE ? 
                ORDER BY marca';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    /* Método para crear SCRUD (create) ................................................................. */
    public function createRow(){
        $sql = 'INSERT INTO marca(marca, id_proveedor, id_tipo_prod)
                VALUES(?, ?, ?)';
        $params = array($this->marcas, $this->proveedor, $this->tipo);
        return Database::executeRow($sql, $params);
    }
    
    /* Método para corroborar si un dato es existente y para el model de editar .............-........... */
    public function readOne(){
        $sql = 'SELECT id_marca, marca, nombre_prv, tipo_producto, marca.id_proveedor, marca.id_tipo_prod
                FROM marca
                INNER JOIN proveedor
                ON proveedor.id_proveedor = marca.id_proveedor
                INNER JOIN tipo_producto
                ON tipo_producto.id_tipo_prod = marca.id_tipo_prod
                WHERE id_marca = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    
    /* Método para actualizar SCRUD (update) ............................................................ */
    public function updateRow(){
        $sql = 'UPDATE marca
                SET marca = ?, id_proveedor = ?, id_tipo_prod = ?
                WHERE id_marca = ?';
        $params = array($this->marcas, $this->proveedor, $this->tipo, $this->id);
        return Database::executeRow($sql, $params);
    }

    /* Método para eliminar SCRUD (delete) .............................................................. */
    public function deleteRow(){
        $sql = 'DELETE FROM marca
                WHERE id_marca = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }   


}