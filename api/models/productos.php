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
}
?>