/*
*   Este controlador es de uso general en las páginas web del sitio público.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para establecer la ruta y parámetros de comunicación con la API.
const API = SERVER + 'Actions/usuario.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Petición para determinar si se ha iniciado sesión.
    fetch(API + 'getUser', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se define una variable para asignar el encabezado del documento.
                let header = '';
                // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
                if (response.session) {
                    header = `
                    <nav class="navbar navbar-expand-lg navbar-light navbar-dark">
                    <div class="container-fluid">
                        <img src="../resources/img/logo.jpeg" height="80">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="login.html">login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="index.html">Menu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="listados.html">Usuario</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="historial.html">Historial de
                                        facturas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="inventario.html">Inventario </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Facturas
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="facturan.html">Factura Normal</a></li>
                                        <li><a class="dropdown-item" href="credito.html">Factura credito</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                        <a onclick="logOut()" class="nav-link">Cerrar sesión</a>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                    `;
                } else {
                    header = `
                    <nav class="navbar navbar-expand-lg navbar-light navbar-dark">
                    <div class="container-fluid">
                        <img src="../resources/img/logo.jpeg" height="80">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="login.html">login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="signup.html">resistrarse</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                    `;
                }
                // Se asigna a la página web el contenido del encabezado.
                document.querySelector('header').innerHTML = header;
    
                // Se establece el pie del encabezado.
                const footer = `
                <div class="row justify-content-center mb-0 pt-5 pb-0 row-2 px-3">
                <div class="col-12">
                    <div class="row row-2">
                        <div class="col-sm-3 text-md-center">
                            <h5><span> <i class="fa fa-firefox text-light" aria-hidden="true"></i></span><b> Ifco</b></h5>
                        </div>
                        <div class="col-sm-3  my-sm-0 mt-5">
                            <ul class="list-unstyled">
                                <li class="mt-0">HTML</li>
                            </ul>
                        </div>
                        <div class="col-sm-3  my-sm-0 mt-5">
                            <ul class="list-unstyled">
                                <li class="mt-0"></li>
                                <li>Bootstrap</li>
                            </ul>
                        </div>
                        <div class="col-sm-3  my-sm-0 mt-5">
                        <ul class="list-unstyled">
                            <li class="mt-0"></li>
                            <li>JavaScript</li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-0 pt-0 row-1 mb-0  px-sm-3 px-2">
                <div class="col-12">
                    <div class="row my-4 row-1 no-gutters">
                        <div class="col-sm-3 col-auto text-center"><small>&#9400; ifco</small></div>
                        <div class="col-md-3 col-auto "></div>
                        <div class="col-md-3 col-auto"></div>
                        <div class="col  my-auto text-md-left  text-right "> <small><span><img
                                        src="https://i.imgur.com/TtB6MDc.png" class="img-fluid " width="25"></span>
                                <span><img src="https://i.imgur.com/N90KDYM.png" class="img-fluid "
                                        width="25"></span></small> </div>
                    </div>
                </div>
            </div>
                `;
                // Se asigna a la página web el contenido del pie.
                document.querySelector('footer').innerHTML = footer;

            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
});