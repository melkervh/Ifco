<?php

require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/detallefactu.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $detallefactu= new Detalle;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action'])
        {
            case 'readAll':
                if ($result['dataset'] = $detallefactu->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                case 'search':
                    $_POST = $detallefactu->validateForm($_POST);
                    if ($_POST['search'] == '') {
                        $result['exception'] = 'Ingrese un valor para buscar';
                    } elseif ($result['dataset'] = $detallefactu->searchRows($_POST['search'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Valor encontrado';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay coincidencias';
                    }
                    break;
            case 'create':
                $_POST = $detallefactu->validateForm($_POST);
                if (!$detallefactu->setIdProducto($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$detallefactu->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad no valida';
                } elseif (!$detallefactu->setPrecioU($_POST['precioU'])) {
                    $result['exception'] = 'Precio no valido';
                }elseif (!$detallefactu->setPreciototal($_POST['total'])) {
                    $result['exception'] = 'Precio no valido';
                }elseif ($detallefactu->createDetalle()) {
                } else {
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
