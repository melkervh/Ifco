<?php
/* Clase para manejar el historial de la base de datos. */
/* Es clase hija de Validator. */

class Clientes extends Validator
{
    /* Método para cargar el historial ....................................................... */
    public function readAll()
    {
        $sql = 'SELECT nombre_cli, apellido_cli, "DUI",telefono
        FROM cliente
        ORDER BY nombre_cli';
        $params = null;
        return Database::getRows($sql, $params);
    }
    public function ReporteCliente()
    {
        $sql = 'SELECT nombre_cli, apellido_cli, "DUI",telefono,departamento
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
}