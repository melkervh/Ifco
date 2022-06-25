<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/crearcredito.php');


// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $crearcredito = new createcredito;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])OR TRUE) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action'])
        {
            case 'createcliente':
                $_POST = $crearcredito ->validateForm($_POST);
                if (!$crearcredito->setNombrescliente($_POST['nombre_cli'])) {
                    $result['exception'] = 'nombre incorrecto';
                } elseif (!$crearcredito->setApellidoscliente($_POST['apellido_cliente'])) {
                    $result['exception'] = 'apellido no valido';
                } elseif (!$crearcredito->setDUI($_POST['DUI'])) {
                    $result['exception'] = 'DUI no valida';
                }elseif (!$crearcredito->setDepartamentoClie($_POST['departamento'])) {
                    $result['exception'] = 'direcion no valido';        
                }elseif (!$crearcredito->setMunicipio($_POST['municipio'])) {
                    $result['exception'] = 'direcion no valido';        
                }elseif ($crearcredito->createClienteCredito()) {
                    $result['status'] = 1;
                    $result['message'] = 'factura creado' ;
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
                case 'createcredito':
                  $_POST =$crearcredito->validateForm($_POST);
                if (!$crearcredito->setNotamision($_POST['mision'])) {
                $result['exception'] ='nota  incorrecto';
                } elseif (!$crearcredito->setcondicion($_POST['condicion'])) {
                    $result['exception'] ='condicion no valido';
                }elseif (!$crearcredito->setgiro($_POST['giro'])) {
                    $result['exception'] ='giro no valido';
                }elseif (!$crearcredito->setVia($_POST['via'])) {
                    $result['exception'] ='via no valido';
                }elseif (!$crearcredito->setfechacre($_POST['fecha_cre'])) {
                        $result['exception'] = 'fecha no valida';
                } elseif ($crearcredito->createCredito()) {
                        $result['status'] = 1;
                        $result['message'] ='factura creada' ;
                }else {
                        $result['exception'] = Database::getException();;
                }
                break;
                case 'createdetallecredi':
                $_POST = $crearcredito->validateForm($_POST);
                if (!$crearcredito->setIdProductoCre($_POST['codigo01'])) {
                $result['exception'] = 'codigo no valido ';
                } elseif (!$crearcredito->setNombrCre($_POST['nombre_pro'])) {
                $result['exception'] = 'nombre del producto no valido';
                }elseif (!$crearcredito->setCantidadCre($_POST['cantidad_cre'])) {
                $result['exception'] = 'cantidad no valida';
                }elseif (!$crearcredito->setPrecioUni($_POST['precio_u'])) {
                $result['exception'] = 'precio unidad no valido';
                }elseif (!$crearcredito->setTotal($_POST['total'])) {
                $result['exception'] = 'precio no valido';
                }elseif ($crearcredito->createDetalleCre()) {
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