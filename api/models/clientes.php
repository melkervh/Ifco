<?php
/* Clase para manejar el historial de la base de datos. */
/* Es clase hija de Validator. */

class Clientes extends Validator
{
    /* Método para cargar el historial ....................................................... */
    public function readAll()
    {
        $sql = 'SELECT nombre_cli, apellido_cli, "DUI",telefono, departamento
        FROM cliente
        ORDER BY nombre_cli';
        $params = null;
        return Database::getRows($sql, $params);
    }
    
}