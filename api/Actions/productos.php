<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/productos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $productos = new Productos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario']) || true) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        
        
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            case 'readAll':
                if ($result['dataset'] = $productos->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

            case 'search':
                $_POST = $productos->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $productos->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;

            case 'readOne':
                if (!$productos->setId($_POST['idp'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $productos->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;

            case 'update':
                $_POST = $productos->validateForm($_POST);
                if (!$productos->setId($_POST['idp'])) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif (!$data = $productos->readOne()) {
                    $result['exception'] = 'Marca inexistente';
                } elseif (!$productos->setNombre($_POST['producto'])) {
                    $result['exception'] = 'Nombre del producto incorrecto';
                } elseif (!$productos->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                } elseif (!$productos->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripcion incorrecta';
                } elseif (!$productos->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecta'; 
                } elseif (!$productos->setMarca($_POST['marca_sel'])) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif (!$productos->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto'; 
                } elseif ($productos->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                case 'create':
                    $_POST = $productos->validateForm($_POST);
                    if (!$productos->setNombre($_POST['producto'])) {
                        $result['exception'] = 'Producto incorrecto';
                    } elseif (!$productos->setCantidad($_POST['cantidad'])) {
                        $result['exception'] = 'Cantidad incorrecta';
                    } elseif (!$productos->setDescripcion($_POST['descripcion'])) {
                        $result['exception'] = 'Descripción incorrecta';
                    } elseif (!$productos->setPrecio($_POST['precio'])) {
                        $result['exception'] = 'Precio incorrecta';  
                    } elseif (!isset($_POST['marca_sel'])) {
                        $result['exception'] = 'Seleccione una marca';
                    } elseif (!$productos->setMarca($_POST['marca_sel'])) {
                        $result['exception'] = 'Marca incorrecta';
                    } elseif (!$productos->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                        $result['exception'] = 'Estado incorrecto';
                    } elseif ($productos->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Producto creado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;

            case 'delete':
                if (!$productos->setId($_POST['iddp'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $productos->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($productos->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
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
