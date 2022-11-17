<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/usuarios.php');
require_once('../helpers/2fa.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuarios;
    $auth = new Authenticator;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'password'=>0, 'fechaexp' => null, 'two_factor' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    date_default_timezone_set('America/El_Salvador');
    $date = date('Y-m-d H:i');
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario']) && $_SESSION['fechaexp'] == 1) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['correo_usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['correo_usuario'];
                } else {
                    $result['exception'] = 'Correo de usuario indefinido';
                }
                break;
                //esta el la accion para cerrar sesion
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            //Buscar el two_factor
            case 'knownTwoFactor':
                if ($result['dataset'] = $usuario->readTwoFactor()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Verificación incorrecta';
                }
                break;
                //Saber si esta activa la autenticación en 2 pasos
            case 'get2fa':
                if (!$usuario->setIdUsuario($_SESSION['id_usuario'])) {
                    $result['exception'] = 'Nombre de usuario inválido';
                } elseif (!$usuario->setSecret($auth->generateRandomSecret())) {
                    $result['exception'] = 'Error al generar secreto.';
                } elseif (!$usuario->set2fa()) {
                    $result['exception'] = Database::getException();
                } elseif ($result['dataset'] = $auth->getQR('IFCO', $usuario->getSecret())) {
                    $result['status'] = 1;
                    $result['message'] = 'Activación de autenticación en 2 pasos completa.';
                } else {
                    $result['exception'] = 'Ha ocurrido un error al generar el código QR.';
                }
                break;
                //Activar la autenticación en 2 pasos
            case 'activate2fa':
                if (!$usuario->setIdUsuario($_SESSION['id_usuario'])) {
                    $result['exception'] = 'Nombre de usuario inválido';
                } elseif (!$usuario->setSecret($auth->generateRandomSecret())) {
                    $result['exception'] = 'Error al generar secreto.';
                } elseif (!$usuario->set2fa()) {
                    $result['exception'] = Database::getException();
                } elseif ($result['dataset'] = $auth->getQR('IFCO', $usuario->getSecret())) {
                    $result['status'] = 1;
                    $result['message'] = 'Activación de autenticación en 2 pasos completa.';
                } else {
                    $result['exception'] = 'Ha ocurrido un error al generar el código QR.';
                }
                break;
                //Desactivar la autenticación en 2 pasos
            case 'deactivate2fa':
                if (!$usuario->setIdUsuario($_SESSION['id_usuario'])) {
                    $result['exception'] = 'Nombre de usuario inválido';
                } elseif ($usuario->deactivate2fa()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha desactivado la autenticación en 2 pasos.';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readUsers':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existe al menos un usuario registrado';
                } else {
                    $result['exception'] = 'No existen usuarios registrados';
                }
                break;
                //aqui se registran los usuarios
            case 'register':
                $_POST = $usuario->validateForm($_POST);
                if (!$usuario->setNombreUsuario($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidoUsuario($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreoUsuario($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$usuario->setClaveUsuario($_POST['clave'])) {
                    $result['exception'] = $usuario->getPasswordError();
                } elseif (strpos($_POST['contrasena1'], $_POST['nombre_usuario']) !== false) {
                    $result['exception'] = 'La contraseña no puede contener el nombre del usuario en ella';
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //este el login donde el usuario verifica que a iniciado sesion
            case 'logIn':
                $_POST = $usuario->validateForm($_POST);
                if (!$usuario->checkUser($_POST['correo'])) {
                    $result['exception'] = 'credenciales incorrectas';
                } elseif ($usuario->getFechaIntentos() > $date) {
                    $result['exception'] = 'Tu cuenta esta bloqueada momentaneamente, intentalo más tarde';
                } elseif ($usuario->getIntentos() > 2) {
                    $result['exception'] = 'Limite de intentos alcanzado, tu cuenta ha sido bloqueda temporalmente';
                    $usuario->bloqueoIntentos($_POST['correo'], $date);
                } elseif (!$usuario->checkPassword($_POST['clave'])) {
                    $result['exception'] = 'Credenciales incorrectas.';                    
                    $usuario->intentoFallido($_POST['correo']);
                    $result['status'] = 0;
                    $_SESSION['fechaexp'] = 0;
                } elseif ($usuario->checkPasswordDate() < 90) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_usuario'] = $usuario->getIdUsuario();
                    $_SESSION['correo_usuario'] = $usuario->getCorreoUsuario();
                    $_SESSION['fechaexp'] = 1;
                    $result['two_factor'] = 1;
                }   else {
                    $result['password'] = 1;
                    $result['exception'] = 'La contraseña expiro despues de 90 dias';
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
