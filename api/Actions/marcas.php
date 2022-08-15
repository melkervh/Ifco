<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/marcas.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $marcas = new Marcas;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario']) || true) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        
        
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            case 'readAll':
                if ($result['dataset'] = $marcas->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

            case 'search':
                $_POST = $marcas->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $marcas->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;

            case 'readOne':
                if (!$marcas->setId($_POST['idm'])) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif ($result['dataset'] = $marcas->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Marca inexistente';
                }
                break;

            case 'update':
                $_POST = $marcas->validateForm($_POST);
                if (!$marcas->setId($_POST['idm'])) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif (!$data = $marcas->readOne()) {
                    $result['exception'] = 'Marca inexistente';
                } elseif (!$marcas->setMarcas($_POST['marca_nom'])) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif (!$marcas->setProveedor($_POST['proveedor_sel'])) {
                    $result['exception'] = 'Proveedor incorrecto';
                } elseif (!$marcas->setTipo($_POST['tipo_sel'])) {
                    $result['exception'] = 'Tipo de producto incorrecto';
                } elseif ($marcas->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Marca modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                case 'create':
                    $_POST = $marcas->validateForm($_POST);
                    if (!$marcas->setMarcas($_POST['marca_nom'])) {
                        $result['exception'] = 'Marca incorrecta';
                    } elseif (!isset($_POST['proveedor_sel'])) {
                        $result['exception'] = 'Seleccione una proveedor';
                    } elseif (!$marcas->setProveedor($_POST['proveedor_sel'])) {
                        $result['exception'] = 'Proveedor incorrecto';
                    } elseif (!isset($_POST['tipo_sel'])) {
                        $result['exception'] = 'Seleccione un tipo de producto';
                    } elseif (!$marcas->setTipo($_POST['tipo_sel'])) {
                        $result['exception'] = 'Tipo de producto incorrecto';
                    } elseif ($marcas->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Marca creada correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;

            case 'delete':
                if (!$marcas->setId($_POST['iddm'])) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif (!$data = $marcas->readOne()) {
                    $result['exception'] = 'Marca inexistente';
                } elseif ($marcas->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Marca eliminada correctamente';
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
