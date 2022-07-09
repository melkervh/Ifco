<?php
/* Clase para manejar la tabla producto de la base de datos. */
/* Es clase hija de Validator. */

class Productos extends Validator{

    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombre = null;
    private $descripcion = null;
    private $cantidad = null;
    private $estado = null;
    private $precio = null;
    private $marca = null;
    private $usuario = null;

    /* Métodos para validar y asignar valores de los atributos. */

    public function setId($value){

        if($this->validateNaturalNumber($value)){
            $this->id = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setNombre($value){

        if($this->validateAlphanumeric($value, 1, 100)){
            $this->nombre = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setCantidad($value){

        if($this->validateNaturalNumber($value)){
            $this->cantidad = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if ($this->validateString($value, 1, 600)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if ($this->validateBoolean($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value){

        if($this->validateMoney($value)){
            $this->precio = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setMarca($value){

        if($this->validateNaturalNumber($value)){
            $this->marca = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setUsuario($value){

        if($this->validateNaturalNumber($value)){
            $this->tipo = $usuario;
            return true;
        }else{
            return false;
        }
    }

    /* Métodos para obtener valores de los atributos. */

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getCantidad(){
        return $this->cantidad;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getPrecio(){
        return $this->precio;
    }

    public function getMarca(){
        return $this->marca;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    /* Métodos para marcas ................................................................. */

    /* Método para realizar readAll, para cargar el combobox del Estado del usuario */
    public function readAll(){
        $sql = 'SELECT id_producto, nombre_prodroducto, cantidad_prodroducto, descripcion_producto, estado_producto, producto.id_marca, marca, tipo_producto
                FROM producto
                INNER JOIN marca
                ON producto.id_marca = marca.id_marca
                INNER JOIN tipo_producto
                ON tipo_producto.id_tipo_prod = marca.id_tipo_prod';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /* Método para buscar SCRUD (search) ................................................................ */
    public function searchRows($value){
        $sql = 'SELECT id_producto, nombre_prodroducto, cantidad_prodroducto, descripcion_producto, estado_producto, producto.id_marca, marca, tipo_producto
                FROM producto
                INNER JOIN marca
                ON producto.id_marca = marca.id_marca
                INNER JOIN tipo_producto
                ON tipo_producto.id_tipo_prod = marca.id_tipo_prod
                WHERE nombre_prodroducto ILIKE ? 
                ORDER BY nombre_prodroducto';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    /* Método para crear SCRUD (create) ................................................................. */
    public function createRow(){
        $sql = 'INSERT INTO producto( nombre_prodroducto, cantidad_prodroducto, descripcion_producto, estado_producto, precio_unidad, id_marca, id_usuario)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->cantidad, $this->descripcion, $this->estado, $this->precio, $this->marca, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }
    
    /* Método para corroborar si un dato es existente y para el model de editar .............-........... */
    public function readOne(){
        $sql = 'SELECT id_producto, nombre_prodroducto, cantidad_prodroducto, descripcion_producto, estado_producto, precio_unidad, id_marca
                FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    
    /* Método para actualizar SCRUD (update) ............................................................ */
    public function updateRow(){
        $sql = 'UPDATE producto
                SET nombre_prodroducto = ?, cantidad_prodroducto = ?, descripcion_producto = ?, estado_producto = ?, precio_unidad = ?, id_marca = ?
                WHERE id_producto = ?';
        $params = array($this->nombre, $this->cantidad, $this->descripcion, $this->estado, $this->precio, $this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    /* Método para eliminar SCRUD (delete) .............................................................. */
    public function deleteRow(){
        $sql = 'DELETE FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }   


}