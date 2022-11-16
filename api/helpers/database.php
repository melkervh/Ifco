<?php
/*
*   Clase para realizar las operaciones en la base de datos.
*/
class Database
{
    // Propiedades de la clase para manejar las acciones respectivas.
    private static $connection = null;
    private static $statement = null;
    private static $error = null;

    /*
    *   Método para establecer la conexión con el servidor de base de datos.
    */
    private static function connect()
    {
        // Credenciales para establecer la conexión con la base de datos.
        $server = 'localhost';
        $database = 'IFCO';
        $username = 'postgres';
        $password = '1234';

        // Se crea la conexión mediante la extensión PDO y el controlador para PostgreSQL.
        self::$connection = new PDO('pgsql:host=' . $server . ';dbname=' . $database . ';port=5432', $username, $password);
    }

    /*
    *   Método para ejecutar las siguientes sentencias SQL: insert, update y delete.
    *
    *   Parámetros: $query (sentencia SQL) y $values (arreglo de valores para la sentencia SQL).
    *   
    *   Retorno: booleano (true si la sentencia se ejecuta satisfactoriamente o false en caso contrario).
    */
    public static function executeRow($query, $values)
    {
        try {
            self::connect();
            self::$statement = self::$connection->prepare($query);
            $state = self::$statement->execute($values);
            // Se anula la conexión con el servidor de base de datos.
            self::$connection = null;
            return $state;
        } catch (PDOException $error) {
            // Se obtiene el código y el mensaje de la excepción para establecer un error personalizado.
            self::setException($error->getCode(), $error->getMessage());
            return false;
        }
    }

    /*
    *   Método para obtener el valor de la llave primaria del último registro insertado.
    *
    *   Parámetros: $query (sentencia SQL) y $values (arreglo de valores para la sentencia SQL).
    *   
    *   Retorno: numérico entero (último valor de la llave primaria si la sentencia se ejecuta satisfactoriamente o 0 en caso contrario).
    */
    public static function getLastRow($query, $values)
    {
        try {
            self::connect();
            self::$statement = self::$connection->prepare($query);
            if (self::$statement->execute($values)) {
                $id = self::$connection->lastInsertId();
            } else {
                $id = 0;
            }
            // Se anula la conexión con el servidor de base de datos.
            self::$connection = null;
            return $id;
        } catch (PDOException $error) {
            // Se obtiene el código y el mensaje de la excepción para establecer un error personalizado.
            self::setException($error->getCode(), $error->getMessage());
            return 0;
        }
    }

    /*
    *   Método para obtener un registro de una sentencia SQL tipo SELECT.
    *
    *   Parámetros: $query (sentencia SQL) y $values (arreglo de valores para la sentencia SQL).
    *   
    *   Retorno: arreglo asociativo del registro si la sentencia SQL se ejecuta satisfactoriamente o false en caso contrario.
    */
    public static function getRow($query, $values)
    {
        try {
            self::connect();
            self::$statement = self::$connection->prepare($query);
            self::$statement->execute($values);
            // Se anula la conexión con el servidor de base de datos.
            self::$connection = null;
            return self::$statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            // Se obtiene el código y el mensaje de la excepción para establecer un error personalizado.
            self::setException($error->getCode(), $error->getMessage());
            die(self::getException());
        }
    }

    /*
    *   Método para obtener todos los registros de una sentencia SQL tipo SELECT.
    *
    *   Parámetros: $query (sentencia SQL) y $values (arreglo de valores para la sentencia SQL).
    *
    *   Retorno: arreglo asociativo de los registros si la sentencia SQL se ejecuta satisfactoriamente o false en caso contrario.
    */
    public static function getRows($query, $values)
    {
        try {
            self::connect();
            self::$statement = self::$connection->prepare($query);
            self::$statement->execute($values);
            // Se anula la conexión con el servidor de base de datos.
            self::$connection = null;
            return self::$statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            // Se obtiene el código y el mensaje de la excepción para establecer un error personalizado.
            self::setException($error->getCode(), $error->getMessage());
            die(self::getException());
        }
    }

    /*
    *   Método para establecer un mensaje de error personalizado al ocurrir una excepción.
    *
    *   Parámetros: $code (código del error) y $message (mensaje original del error).
    *
    *   Retorno: ninguno.
    */
    private static function setException($code, $message)
    {
        // Se asigna el mensaje del error original por si se necesita.
        self::$error = utf8_encode($message);
        // Se compara el código del error para establecer un error personalizado.
        switch ($code) {
            case '7':
                self::$error = 'Existe un problema al conectar con el servidor';
                break;
            case '42703':
                self::$error = 'Nombre de campo desconocido';
                break;
            case '23505':
                self::$error = 'Dato duplicado, no se puede guardar';
                break;
            case '42P01':
                self::$error = 'Nombre de tabla desconocido';
                break;
            case '23503':
                self::$error = 'Registro ocupado, no se puede eliminar';
                break;
            //Casos nuevos agregados
            case '23502':
                self::$error = 'El dato no puede ser nulo';
                break;
            case '08P01':
                self::$error = 'Se envían menos parámetros de los requeridos';
                break;
            case 'HY093':
                self::$error = 'Se envían más parámetros de los requeridos';
                break;
            case '22001':
                self::$error = 'Los datos ingresados superan el límite de caracteres permitidos';
                break;
            case '22P02':
                self::$error = 'El tipo de dato ingresado no coincide con la base de datos';
                break;
            case '22007':
                self::$error = 'El formato de fecha no es válido';
                break;
            case '42601':
                self::$error = 'Error de sintaxis en consulta o instrucción a ejecutar';
                break;
            case '42883':
                self::$error = 'Nombre de función desconocido';
                break;
            case '42702':
                self::$error = 'La referencia a la columna es ambigua';
                break;
            case '42712':
                self::$error = 'El nombre de tabla fue especificado más de una vez';
                break;
            case '53000':
                self::$error = 'Recursos insuficientes';
                break;
            case '53100':
                self::$error = 'Espacio en disco lleno';
                break;
            case '53200':
                self::$error = 'No hay memoria disponible';
                break;
            case '53300':
                self::$error = 'Existen demasiadas conexiones activas, vuelva a intentar.';
                break;
            case 'XX000':
                self::$error = 'Ha ocurrido un error interno, vuelva a intentar.';
                break;
            default:
                self::$error = "Ha ocurrido un error, contacte con su administrador para solucionarlo.";
        }
    }

    /*
    *   Método para obtener un error personalizado cuando ocurre una excepción.
    *
    *   Parámetros: ninguno.
    *
    *   Retorno: error personalizado de la sentencia SQL o de la conexión con el servidor de base de datos.
    */
    public static function getException()
    {
        return self::$error;
    }
}
