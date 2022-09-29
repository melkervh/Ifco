<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/detalle.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $detalles = new  Detalles;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;

        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            // Evalua y consulta los registros para cargar la primera tabla 
            case 'showFechas':
                if ($result['dataset'] = $detalles->readAllFechas()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados recientemente';
                }
            break;

            // Evalua y consulta los registros para cargar la segunda tabla.
            case 'showFechasc':
                if ($result['dataset'] = $detalles->readAllFechaCorta()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados recientemente';
                }
            break;
            case 'createdetalle':
                $_POST = $detalles->validateForm($_POST);
                if (!$detalles->setIdProducto($_POST['codigo'])) {
                $result['exception'] = 'id_producto incorrecto';
                } elseif (!$detalles->setPrecioU($_POST['precioU'])) {
                $result['exception'] = 'precio unidad no valido';
                }elseif (!$detalles->setPrecioTotal($_POST['total'])) {
                $result['exception'] = 'precio no valido';
                }elseif (!$detalles-> setCantidadCom($_POST['cantidad'])) {
                $result['exception'] = 'cantidad no valida';
                }elseif (!$detalles->setfact_nor($_POST['codigo2'])) {
                    $result['exception'] = 'codigo factura no valido';
                }elseif ($detalles->createDetalle()) {
                $result['status'] = 1;
                $result['message'] = 'detalle creado' ;     
                } else {
                $result['exception'] = Database::getException();;
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
