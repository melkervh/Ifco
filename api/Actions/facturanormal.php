<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/crearfactura.php');


// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $crearfactu = new createfactura;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])OR TRUE) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action'])
        {
            case 'create':
                $_POST = $crearfactu ->validateForm($_POST);
                if (!$crearfactu ->setNombrecliente($_POST['nombre_cli'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$crearfactu->setApellidocliente($_POST['apellido'])) {
                    $result['exception'] = 'Apellido no valido';
                } elseif (!$crearfactu->setdui($_POST['DUI'])) {
                    $result['exception'] = 'DUI no valido';
                }elseif (!$crearfactu->setDepartamento($_POST['direccion'])) {
                    $result['exception'] = 'Dirección no valida';        
                }elseif ($crearfactu->createCliente()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente creado correctamente.' ;
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
                case 'createfactu':
                  $_POST =$crearfactu->validateForm($_POST);
                if (!$crearfactu->setventa($_POST['venta'])) {
                $result['exception'] = 'Dato de la venta incorrecto';
                } elseif (!$crearfactu->setfecha($_POST['fecha'])) {
                        $result['exception'] = 'Fecha no valida';
                } elseif ($crearfactu->createfactura()) {
                        $result['status'] = 1;
                        $result['message'] = 'Factura creada correctamente.' ;
                }else {
                        $result['exception'] = Database::getException();;
                }
                break;
            default:
            $result['exception'] = 'Acción no disponible dentro de la sesión';
        }        
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
          print(json_encode('Acceso denegado'));
    }  
} else {
    print(json_encode('Recurso no disponible'));
}
?>