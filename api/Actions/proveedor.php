<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/proveedores.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $proveedor = new Proveedores ;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;

        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            // Evalua y consulta los registros para cargar la tabla.
            case 'readAll':
                if ($result['dataset'] = $proveedor ->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $proveedor ->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $proveedor ->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'readOne':
                if (!$proveedor ->setIdProveedor($_POST['id_proveedor'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $proveedor ->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
                case 'create':
                    $_POST = $proveedor->validateForm($_POST);
                    if (!$proveedor->setNombrePrv($_POST['marca'])) {
                        $result['exception'] = 'Nombre incorrecto';
                    } elseif (!$proveedor->setcontacto($_POST['correo_pro'])) {
                        $result['exception'] = 'contacto incorrecto';
                    } elseif ($proveedor->createRow()) {  
                    $result['status'] = 1;
                    }
                    else {
                    $result['exception'] = Database::getException();
                    }
                    break;
            case 'update':
                $_POST = $proveedor ->validateForm($_POST);
                if (!$proveedor ->setIdProveedor($_POST['id_proveedor'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$proveedor ->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$proveedor ->setNombrePrv($_POST['marca'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$proveedor ->setContacto($_POST['correo_pro'])) {
                    $result['exception'] = 'contacto incorrectos';
                } elseif ($proveedor ->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id_proveedor'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$proveedor ->setIdProveedor($_POST['id_proveedor'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$proveedor ->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($proveedor ->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
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
