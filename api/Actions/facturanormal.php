<?php

require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/cliente.php');
require_once('../models/detallefactu.php');
require_once('../models/factura.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente= new cliente;
    $factura= new Factura;
    $detallefactu= new Detalle;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action'])
        {
            case 'create':
                $_POST = $detallefactu->validateForm($_POST);
                if (!$detallefactu->setNombrecliente($_POST['nombre'])) {
                    $result['exception'] = 'nombre incorrecto';
                } elseif (!$detallefactu->setApellidocliente($_POST['apellido'])) {
                    $result['exception'] = 'apellido no valida';
                } elseif (!$detallefactu->setdui($_POST['DUI'])) {
                    $result['exception'] = 'DUI no valida';
                }elseif (!$detallefactu->setDepartamento($_POST['dirrecion'])) {
                    $result['exception'] = 'direcion no valida';
                }elseif ($detallefactu-> createCliente()) {
                } elseif (!$factura->setventa($_POST['venta'])) {
                    $result['exception'] = 'dato de la venta incorrecto';
                } elseif (!$factura->setfecha($_POST['fecha'])) {
                    $result['exception'] = 'fecha no valida';
                } elseif ($factura->createfactura()) {
                }elseif (!$detallefactu->setIdProducto($_POST['id_producto'])) {
                    $result['exception'] = 'id_producto incorrecto';
                } elseif (!$detallefactu->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'cantidad no valida';
                } elseif (!$detallefactu->setPrecioU($_POST['precioU'])) {
                    $result['exception'] = 'precio no valida';
                }elseif (!$detallefactu->setPreciototal($_POST['total'])) {
                    $result['exception'] = 'precio no valida';
                }elseif ($detallefactu->createDetalle()) {
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