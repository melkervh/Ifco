<?php

class inventario extends Validator
{
    // Declaración de atributos (propiedades).
    private $id_producto = null;
    private $nombre_prodroducto = null;
    private $cantidad_prodroducto = null;
    private $descripcion_producto = null;
    private $estado_producto = null;
    private $precio_unidad = null;
    private $id_marca = null;
    private $id_usuario = null;


     /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdProducto($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombreProducto($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->nombre_prodroducto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidadProducto($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->cantidad_prodroducto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcionProducto($value)
    {
        if ($this->validateString($value, 1, 250)) {
            $this->descripcion_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstadoProducto($value)
    {
        if ($this->validateBoolean($value)) {
            $this->estado_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecioProducto($value)
    {
        if ($this->validateMoney($value)) {
            $this->precio_unidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdMarca($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_marca = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdUsuario($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIProducto()
    {
        return $this->id_producto;
    }

    public function getNombreProducto()
    {
        return $this->nombre_prodroducto;
    }

    public function getCantidadProducto()
    {
        return $this->cantidad_prodroducto;
    }

    public function getDescripcionProducto()
    {
        return $this->descripcion_producto;
    }

    public function getEstadoProducto()
    {
        return $this->estado_producto;
    }

    public function getPrecioProducto()
    {
        return $this->precio_unidad;
    }

    public function getIdMarca()
    {
        return $this->id_marca;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

      /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*Buscador de productos*/
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_prodroducto, cantidad_prodroducto, descripcion_producto, estado_producto, precio_unidad
                FROM producto INNER JOIN marca USING(id_marca)
                WHERE nombre_prodroducto ILIKE ? OR descripcion_producto ILIKE ?
                ORDER BY nombre_prodroducto';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
    
    /*Crear un producto nuevo*/
    public function createRow()
    {
        $sql = 'INSERT INTO productos(nombre_prodroducto, cantidad_prodroducto, descripcion_producto, estado_producto, precio_unidad, id_marca, id_usuario)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_prodroducto, $this->cantidad_prodroducto, $this->descripcion_producto,  $this->estadestado_producto, $this->precio_unidad,  $this->id_marca, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }
?>