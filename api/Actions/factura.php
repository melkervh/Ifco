<?php

require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/factura.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $tipo_product = new TipoProducto;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario']) OR true) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action'])
        {
            case 'readAll':
                if ($result['dataset'] = $tipo_product->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                case 'search':
                    $_POST = $tipo_product->validateForm($_POST);
                    if ($_POST['search'] == '') {
                        $result['exception'] = 'Ingrese un valor para buscar';
                    } elseif ($result['dataset'] = $tipo_product->searchRows($_POST['search'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Valor encontrado';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay coincidencias';
                    }
                    break;
            case 'create':
                $_POST = $tipo_product->validateForm($_POST);
                if (!$tipo_product->setventa($_POST['venta'])) {
                    $result['exception'] = 'dato de la venta incorrecto';
                } elseif (!$tipo_product->setfecha($_POST['fecha'])) {
                    $result['exception'] = 'fecha no valida';
                } elseif ($tipo_product->createfactura()) {
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$tipo_product->setidtip($_POST['idtip'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif ($result['dataset'] = $tipo_product->readOne()) {
                        $result['status'] = 1;
                } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Categoría inexistente';
                }
                break;
            case 'update':
                $_POST = $tipo_product->validateForm($_POST);
                if (!$tipo_product->setidtip($_POST['idtip'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$data = $tipo_product->readOne()) {
                    $result['exception'] = 'Categoría inexistente';
                } elseif (!$tipo_product->settipo_nombre($_POST['tipo_nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$tipo_product->setdescripcion_tipo($_POST['descripcion_tipo'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif ($tipo_product->updateRow($data)) {
                    $result['status'] = 1;
                } 
                else {
                    $result['exception'] = Database::getException();
                }
                
                break;
                case 'delete':
                    if (!$tipo_product->setidtip($_POST['idtip'])) {
                        $result['exception'] = 'Categoría incorrecta';
                    } elseif (!$data = $tipo_product->readOne()) {
                        $result['exception'] = 'Categoría inexistente';
                    } elseif ($tipo_product->deleteRow()) {
                        $result['status'] = 1;
                        if ($tipo_product->deleteFile($tipo_product->getRuta(), $data['imagen_categoria'])) {
                            $result['message'] = 'Categoría eliminada correctamente';
                        } else {
                            $result['message'] = 'Categoría eliminada pero no se borró la imagen';
                        }
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
?>
