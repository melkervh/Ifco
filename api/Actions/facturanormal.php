<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/crearfactura.php');


// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $crearfactu = new createfactura;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])OR TRUE) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action'])
        {
            case 'create':
                $_POST = $crearfactu ->validateForm($_POST);
                if (!$crearfactu ->setNombrecliente($_POST['nombre_cli'])) {
                    $result['exception'] = 'nombre incorrecto';
                } elseif (!$crearfactu->setApellidocliente($_POST['apellido'])) {
                    $result['exception'] = 'apellido no vslido';
                } elseif (!$crearfactu->setdui($_POST['DUI'])) {
                    $result['exception'] = 'DUI no valida';
                }elseif (!$crearfactu->setDepartamento($_POST['direccion'])) {
                    $result['exception'] = 'direcion no valido';        
                }elseif ($crearfactu->createCliente()) {
                    $result['status'] = 1;
                    $result['message'] = 'cliente creado' ;
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
                case 'createfactu':
                  $_POST =$crearfactu->validateForm($_POST);
                if (!$crearfactu->setventa($_POST['venta'])) {
                $result['exception'] = 'dato de la venta incorrecto';
                } elseif (!$crearfactu->setfecha($_POST['fecha'])) {
                        $result['exception'] = 'fecha no valida';
                } elseif ($crearfactu->createfactura()) {
                        $result['status'] = 1;
                        $result['message'] = 'factura creada' ;
                }else {
                        $result['exception'] = Database::getException();;
                }
                break;
                case 'createdetalle':
                $_POST = $crearfactu->validateForm($_POST);
                if (!$crearfactu->setIdProducto($_POST['id_producto'])) {
                $result['exception'] = 'id_producto incorrecto';
                } elseif (!$crearfactu->setnombre_com($_POST['nombre_com'])) {
                $result['exception'] = 'nombre no valido';
                } elseif (!$crearfactu->setPrecioU($_POST['precioU'])) {
                $result['exception'] = 'precio unidad no valido';
                }elseif (!$crearfactu->setPrecioTotal($_POST['total'])) {
                $result['exception'] = 'precio no valido';
                }elseif (!$crearfactu-> setCantidadCom($_POST['cantidad'])) {
                $result['exception'] = 'cantidad no valida';
                }elseif (!$crearfactu->setfact_nor($_POST['codigo2'])) {
                $result['exception'] = 'codigo factura no valido';
                }elseif ($crearfactu->createDetalle()) {
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