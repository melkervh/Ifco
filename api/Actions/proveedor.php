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
            case 'readAllPro':
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
                if ($_POST['searchP'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $proveedor ->searchRows2($_POST['searchP'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'readOne':
                if (!$proveedor ->setIdUsuario($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $proveedor ->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'update':
                $_POST = $proveedor ->validateForm($_POST);
                if (!$proveedor ->setIdUsuario($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$proveedor ->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$proveedor ->setNombres($_POST['nombre_usuario'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$proveedor ->setApellidos($_POST['apellido_usuario'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$proveedor ->setCorreo($_POST['correo_usuario'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$proveedor ->setClave($_POST['clave_usuario'])) {
                    $result['exception'] = 'clave incorrecto';
                }elseif ($proveedor ->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id_usuario'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$proveedor ->setIdUsuario($_POST['id_usuario'])) {
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
                case 'create':
                    $_POST = $proveedor ->validateForm($_POST);
                    if (!$proveedor ->setNombreUsuario($_POST['nombre_usuario'])) {
                        $result['exception'] = 'Nombres incorrectos';
                    } elseif (!$proveedor ->setApellidoUsuario($_POST['apellido_usuario'])) {
                        $result['exception'] = 'Apellidos incorrectos';
                    } elseif (!$proveedor ->setCorreoUsuario($_POST['correo_usuario'])) {
                        $result['exception'] = 'Correo incorrecto';
                    } elseif ($_POST['clave_usuario'] != $_POST['confirmar']) {
                        $result['exception'] = 'Claves diferentes';
                    } elseif (!$proveedor ->setClaveUsuario($_POST['clave_usuario'])) {
                        $result['exception'] = $proveedor ->getPasswordError();
                    } elseif ($proveedor ->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Usuario registrado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
                    case 'changePassword':
                        $_POST = $proveedor ->validateForm($_POST);
                        if (!$proveedor ->setId($_SESSION['id_usuario'])) {
                            $result['exception'] = 'Usuario incorrecto';
                        } elseif (!$proveedor ->checkPassword($_POST['actual'])) {
                            $result['exception'] = 'Clave actual incorrecta';
                        } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                            $result['exception'] = 'Claves nuevas diferentes';
                        } elseif (!$proveedor ->setClave($_POST['nueva'])) {
                            $result['exception'] = $proveedor ->getPasswordError();
                        } elseif ($proveedor ->changePassword()) {
                            $result['status'] = 1;
                            $result['message'] = 'Contraseña cambiada correctamente';
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
