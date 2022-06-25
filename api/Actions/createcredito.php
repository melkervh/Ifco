<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/crearcredito.php');


// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $createcredito  = new createcredito ;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action'])
        {
            case 'create':
                $_POST = $createcredito  ->validateForm($_POST);
                if (!$createcredito  ->setNombrescliente($_POST['nombre_cli'])) {
                    $result['exception'] = 'nombre incorrecto';
                } elseif (!$createcredito ->setApellidoscliente($_POST['apellido_cli'])) {
                    $result['exception'] = 'apellido no vslido';
                } elseif (!$createcredito ->setDUI($_POST['DUI'])) {
                    $result['exception'] = 'DUI no valida';
                }elseif (!$createcredito ->setDepartamentoClie($_POST['departamento'])) {
                    $result['exception'] = 'direcion no valido';        
                }elseif (!$createcredito ->setMunicipio($_POST['municipio'])) {
                    $result['exception'] = 'direcion no valido';        
                }elseif ( $createcredito ->createClienteCredito()) {
                    $result['status'] = 1;
                    $result['message'] = 'cliente creado' ;
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
                case 'createfactuC':
                $_POST = $createcredito ->validateForm($_POST);
                if (!$createcredito ->setNotamision($_POST['mision'])) {
                $result['exception'] = 'dato de la venta incorrecto';
                } elseif (!$createcredito ->setcondicion($_POST['condicion'])) {
                        $result['exception'] = 'condicion no valida';
                }elseif (!$createcredito ->setgiro($_POST['giro'])) {
                    $result['exception'] = 'giro no valida';
                } elseif (!$createcredito ->setVia($_POST['via'])) {
                    $result['exception'] = 'via no valida';
                } elseif (!$createcredito ->setfechacre($_POST['fecha'])) {
                $result['exception'] = 'fecha no valida';
                }elseif ($createcredito ->createCredito()) {
                        $result['status'] = 1;
                        $result['message'] = 'factura creada' ;
                }else {
                        $result['exception'] = Database::getException();;
                }
                break;
                case 'createdetallec':
                $_POST = $createcredito ->validateForm($_POST);
                if (!$createcredito ->setIdProductoCre($_POST['codigo01'])) {
                $result['exception'] = 'codigo incorrecto';
                }  elseif (!$createcredito ->setNombrCre($_POST['nombre_pro'])) {
                $result['exception'] = 'nombre no valido';
                }elseif (!$createcredito ->setCantidadCre($_POST['cantidad'])) {
                $result['exception'] = 'precio no valido';
                }elseif (!$createcredito -> setPrecioUni($_POST['precio_u'])) {
                $result['exception'] = 'precio no valida';
                }elseif (!$createcredito -> setTotal($_POST['total'])) {
                $result['exception'] = 'precio total no valida';
                }elseif ($createcredito ->createDetalleCre()) {
                $result['status'] = 1;
                $result['message'] = 'detalle creado' ;     
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