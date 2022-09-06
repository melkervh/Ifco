<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/usuarios.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $contraseña= new Usuarios;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    $result['session'] = 1;
    // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
    switch ($_GET['action']) {
        case 'checkPasswordDate':
            if ($contraseña->checkPasswordDate() < 90) {
                $result['status'] = 1;
                $result['message'] = 'Existe al menos un usuario registrado';
            } else {
                $result['exception'] = 'No existen usuarios registrados';
            }
            break;
        case 'cambiocontraseña':
            $_POST = $contraseña->validateForm($_POST);
            if (!$contraseña->setIdUsuario($_SESSION['id_usuario'])) {
                $result['exception'] = 'Usuario incorrecto';
            } elseif ($_POST['clave_usuario'] != $_POST['confirmar']) {
                $result['exception'] = 'Claves diferentes';
            }elseif (!$contraseña->setClaveUsuario($_POST['clave_usuario'])) {
                $result['exception'] = $contraseña->getPasswordError();
            }elseif ($contraseña->CambioDeClave()) {
                $result['status'] = 1;
                $result['message'] = 'Usuario modificado correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
            break;
        default:
            $result['exception'] = 'Acción no disponible fuera de la sesión';
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
?>