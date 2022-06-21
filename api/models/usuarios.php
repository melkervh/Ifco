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

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function getNombreUsuario()
    {
        return $this->nombre_usuario;
    }

    public function getApellidoUsuario()
    {
        return $this->apellido_usuario;
    }

    public function getClaveUsuario()
    {
        return $this->clave_usuario;
    }

    public function getCorreoUsuario()
    {
        return $this->correo_usuario;
    }

    /*
    *   Métodos para gestionar la cuenta del usuario.
    */

    /*Funcion para la comprobacion del correo*/
    public function ($correo_usuario)
    {
        $sql = 'SELECT id_usuario FROM usuario WHERE correo_usuario = ?';
        $params = array($correo_usuario);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_usuario = $data['id_usuario'];
            $this->correo_usuario = $correo_usuario;
            return true; /*si se encuentra un id con ese correo retorna a un true*/
        } else {
            return false; /*de lo contrario retorna a un false*/
        }
    }

    /*Funcion para comprobar la clave*/
    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuario WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['clave_usuario'])) {
            return true;
        } else {
            return false;
        }
    }

}
?>
