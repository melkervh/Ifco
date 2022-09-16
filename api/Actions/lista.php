<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/usuarios.php');
require_once('../models/proveedores.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $listas = new  Usuarios;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;

        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            // Evalua y consulta los registros para cargar la tabla.
            case 'readAll':
                if ($result['dataset'] = $listas->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $listas->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $listas->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'readOne':
                if (!$listas->setIdUsuario($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $listas->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'update':
                $_POST = $listas->validateForm($_POST);
                if (!$listas->setIdUsuario($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$listas->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$listas->setNombreUsuario($_POST['nombre_usuario'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$listas->setApellidoUsuario($_POST['apellido_usuario'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$listas->setCorreoUsuario($_POST['correo_usuario'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif ($_POST['clave_usuario'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                }elseif (!$listas->setClaveUsuario($_POST['clave_usuario'])) {
                    $result['exception'] = $listas->getPasswordError();
                }elseif ($listas->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id_usuario'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$listas->setIdUsuario($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$listas->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($listas->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                case 'create':
                    $_POST = $listas->validateForm($_POST);
                    if (!$listas->setNombreUsuario($_POST['nombre_usuario'])) {
                        $result['exception'] = 'Nombres incorrectos';
                    } elseif (!$listas->setApellidoUsuario($_POST['apellido_usuario'])) {
                        $result['exception'] = 'Apellidos incorrectos';
                    } elseif (!$listas->setCorreoUsuario($_POST['correo_usuario'])) {
                        $result['exception'] = 'Correo incorrecto';
                    } elseif ($_POST['clave_usuario'] != $_POST['confirmar']) {
                        $result['exception'] = 'Claves diferentes';
                    } elseif (!$listas->setClaveUsuario($_POST['clave_usuario'])) {
                        $result['exception'] = $listas->getPasswordError();
                    } elseif (strpos($_POST['clave_usuario'], $_POST['nombre_usuario']) !== false) {
                        $result['exception'] = 'La contraseña no puede contener el nombre del usuario en ella';
                    } elseif (strpos($_POST['clave_usuario'], $_POST['apellido_usuario']) !== false) {
                        $result['exception'] = 'La contraseña no puede contener el apellido del usuario en ella';
                    } elseif ($listas->createRow()) {
                        if ($listas->actualizarcontraseña()) {
                            $result['status'] = 1;
                            $result['message'] = 'Usuario registrado correctamente';
                        }
                        else {
                            $result['exception'] = 'Ni modo no se acutualizo la fecha';
                        }
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
                    case 'changePassword':
                        $_POST = $listas->validateForm($_POST);
                        if (!$listas->setId($_SESSION['id_usuario'])) {
                            $result['exception'] = 'Usuario incorrecto';
                        } elseif (!$listas->checkPassword($_POST['actual'])) {
                            $result['exception'] = 'Clave actual incorrecta';
                        } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                            $result['exception'] = 'Claves nuevas diferentes';
                        } elseif (!$listas->setClave($_POST['nueva'])) {
                            $result['exception'] = $listas->getPasswordError();
                        } elseif ($listas->changePassword()) {
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
