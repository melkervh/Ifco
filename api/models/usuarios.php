<?php
/*
*	Clase para manejar la tabla usuarios de la base de datos.
*   Es clase hija de Validator.
*/
class Usuarios extends Validator
{
    // Declaración de atributos (propiedades).
    private $id_usuario = null;
    private $nombre_usuario = null;
    private $apellido_usuario = null;
    private $clave_usuario = null;
    private $correo_usuario = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdUsuario($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombreUsuario($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->nombre_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidoUsuario($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->apellido_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClaveUsuario($value)
    {
        if ($this->validatePassword($value)) {
            $this->clave_usuario = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    public function setCorreoUsuario($value)
    {
        if ($this->validateEmail($value)) {
            $this->correo_usuario = $value;
            return true;
        } else {
            return false;
        }
    }
}
