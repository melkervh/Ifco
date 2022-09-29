// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_PRODUCTOS = SERVER + 'Actions/productos.php?action=';
const API_MARCAS = SERVER + 'Actions/marcas.php?action=';
const API_TIPO = SERVER + 'Actions/tipo_producto.php?action=';
// Constantes para el select "marca"
const ENDPOINT_MARCA = SERVER + 'Actions/marcas.php?action=readAll';
const ENDPOINT_TIPO = SERVER + 'Actions/tipo_producto.php?action=readAll';
const ENDPOINT_PROVEEDOR = SERVER + 'Actions/proveedor.php?action=readAll';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    openShowProductos();  

});

//
//
//
// PRODUCTOS
//
//
//

// Para mostrar los productos recientes
function openShowProductos() {

    // Petición para obtener los datos del registro solicitado.
    fetch(API_PRODUCTOS + 'readAll', {
        method: 'get'
    }).then(function (request) {

        // Se verifica si la petición es correcta.
        if (request.ok) {
            request.json().then(function (response) {

                let data = [];
                // Se comprueba si la respuesta es satisfactoria.
                if (response.status) {

                    data = response.dataset;
                    let content = '';
                    data.map(function (row) {

                        var estado;
                        if (row.estado_producto == '1') {
                            estado = "Disponible";
                        }
                        if (row.estado_producto == '0') {
                            estado = "No disponible";
                        }

                        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                        content += `
                        <tr>
                       
                        <td>${row.nombre_prodroducto}</td>
                        <td>${row.cantidad_prodroducto}</td>
                        <td>${row.descripcion_producto}</td>
                        <td>${estado}</td>
                        <td>${row.marca}</td>
                        <td>${row.tipo_producto}</td>
                        <td>
                            <a onclick="openUpdateProductos(${row.id_producto})" data-bs-toggle="modal" data-bs-target="#productos-modal">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a onclick="openDeleteProductos(${row.id_producto})">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                        </tr>
                        `
                    });

                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('tabla-productos').innerHTML = content;

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Buscador.
function BuscadorProductos(form) {

    // Petición para solicitar los productos.
    fetch(API_PRODUCTOS + 'search', {
        method: 'post',
        body: new FormData(document.getElementById(form))
    }).then(function (request) {
        // Se verifica si la petición es correcta.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria.
                if (response.status) {

                    sweetAlert(1, response.message, null);

                    let content = '';
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        var estado;
                        if (row.estado_producto == '1') {
                            estado = "Disponible";
                        }
                        if (row.estado_producto == '0') {
                            estado = "No disponible";
                        }

                        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                        content += `
                        <tr>
               
                        <td>${row.nombre_prodroducto}</td>
                        <td>${row.cantidad_prodroducto}</td>
                        <td>${row.descripcion_producto}</td>
                        <td>${estado}</td>
                        <td>${row.marca}</td>
                        <td>${row.tipo_producto}</td>
                        <td>
                            <a onclick="openUpdateProductos(${row.id_producto})" data-bs-toggle="modal" data-bs-target="#productos-modal">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a onclick="openDeleteProductos(${row.id_producto})">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                        </tr>
                        `
                    });

                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('tabla-productos').innerHTML = content;

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Buscador para productos.
// Método manejador de eventos que se ejecuta cuando se envía el formulario de buscar.
document.getElementById('buscarproductos-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se llama a la función que realiza la búsqueda.
    BuscadorProductos('buscarproductos-form');
});

// Función para preparar el formulario al momento de insertar un registro.
function openCreateProductos() {

    // Se asigna el título para la caja de diálogo (modal).
    document.getElementById('modal-title').textContent = 'Crear producto';
    // Se llama a la función para cargar los select.
    fillSelect(ENDPOINT_MARCA, 'marca_sel', null);
}

// Función para preparar el formulario al momento de modificar un registro.
function openUpdateProductos(id) {
    // Se asigna el título para la caja de diálogo (modal).
    document.getElementById('modal-title').textContent = 'Editar producto';

    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('idp', id);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_PRODUCTOS + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se inicializan los campos del formulario con los datos del registro seleccionado.
                    document.getElementById('idp').value = response.dataset.id_producto;
                    document.getElementById('producto').value = response.dataset.nombre_prodroducto;
                    document.getElementById('cantidad').value = response.dataset.cantidad_prodroducto;
                    document.getElementById('descripcion').value = response.dataset.descripcion_producto;
                    document.getElementById('precio').value = response.dataset.precio_unidad;
                    fillSelect(ENDPOINT_MARCA, 'marca_sel', response.dataset.id_marca);
                    if (response.dataset.estado_producto) {
                        document.getElementById('estado').checked = true;
                    } else {
                        document.getElementById('estado').checked = false;
                    }

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de guardar.
document.getElementById('productos-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se define una variable para establecer la acción a realizar en la API.
    let action = '';
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
    (document.getElementById('idp').value) ? action = 'update' : action = 'create';
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_PRODUCTOS, action, 'productos-form', 'productos-modal');
    openShowProductos();
});

// Función para establecer el registro a eliminar y abrir una caja de diálogo de confirmación.
function openDeleteProductos(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('iddp', id);
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
       confirmDelete(API_PRODUCTOS, data);
    openShowProductos();
}

//
//
//
// MARCAS
//
//
//

// Para mostrar los productos recientes
function openShowMarcas() {

    // Petición para obtener los datos del registro solicitado.
    fetch(API_MARCAS + 'readAll', {
        method: 'get'
    }).then(function (request) {

        // Se verifica si la petición es correcta.
        if (request.ok) {
            request.json().then(function (response) {

                let data = [];
                // Se comprueba si la respuesta es satisfactoria.
                if (response.status) {

                    data = response.dataset;
                    let content = '';
                    data.map(function (row) {

                        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                        content += `
                        <tr>
                
                        <td>${row.marca}</td>
                        <td>${row.nombre_prv}</td>
                        <td>${row.tipo_producto}</td>
                        <td>
                            <a onclick="openUpdateMarcas(${row.id_marca})" data-bs-toggle="modal" data-bs-target="#marcas-modal">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a onclick="openDeleteMarcas(${row.id_marca})">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                            <a onclick="openReporteMarcas(${row.id_marca})">
                                <i class="fa-solid fa-file-pdf"></i>
                            </a>
                        </td>
                        </tr>
                        `
                    });

                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('tabla-marcas').innerHTML = content;

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Buscador.
function BuscadorMarcas(form) {

    // Petición para solicitar los productos.
    fetch(API_MARCAS + 'search', {
        method: 'post',
        body: new FormData(document.getElementById(form))
    }).then(function (request) {
        // Se verifica si la petición es correcta.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria.
                if (response.status) {

                    sweetAlert(1, response.message, null);

                    let content = '';
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {

                        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                        content += `
                        <tr>
                    
                        <td>${row.marca}</td>
                        <td>${row.nombre_prv}</td>
                        <td>${row.tipo_producto}</td>
                        <td>
                            <a onclick="openUpdateMarcas(${row.id_marca})" data-bs-toggle="modal" data-bs-target="#marcas-modal">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a onclick="openDeleteMarcas(${row.id_marca})">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                        </tr>
                        `
                    });

                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('tabla-marcas').innerHTML = content;

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Buscador para productos.
// Método manejador de eventos que se ejecuta cuando se envía el formulario de buscar.
document.getElementById('buscarmarcas-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se llama a la función que realiza la búsqueda.
    BuscadorMarcas('buscarmarcas-form');
});

// Función para preparar el formulario al momento de insertar un registro.
function openCreateMarcas() {

    // Se asigna el título para la caja de diálogo (modal).
    document.getElementById('modal-title').textContent = 'Crear marca';
    // Se llama a la función para cargar los select.
    fillSelect(ENDPOINT_PROVEEDOR, 'proveedor_sel', null);
    fillSelect(ENDPOINT_TIPO, 'tipo_sel', null);
}

// Función para preparar el formulario al momento de modificar un registro.
function openUpdateMarcas(id) {
    // Se asigna el título para la caja de diálogo (modal).
    document.getElementById('modal-title').textContent = 'Editar producto';

    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('idm', id);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_MARCAS + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se inicializan los campos del formulario con los datos del registro seleccionado.
                    document.getElementById('idm').value = response.dataset.id_marca;
                    document.getElementById('marca_nom').value = response.dataset.marca;
                    fillSelect(ENDPOINT_PROVEEDOR, 'proveedor_sel', response.dataset.id_proveedor);
                    fillSelect(ENDPOINT_TIPO, 'tipo_sel', response.dataset.id_tipo_prod);

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de guardar.
document.getElementById('marcas-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se define una variable para establecer la acción a realizar en la API.
    let action = '';
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
    (document.getElementById('idm').value) ? action = 'update' : action = 'create';
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_MARCAS, action, 'marcas-form', 'marcas-modal');
    openShowMarcas();
});

// Función para establecer el registro a eliminar y abrir una caja de diálogo de confirmación.
function openDeleteMarcas(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('iddm', id);
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
       confirmDelete(API_MARCAS, data);
    openShowMarcas();
}

//
//
//
// TIPO DE PRODUCTO
//
//
//

// Para mostrar los productos recientes
function openShowTipo() {

    // Petición para obtener los datos del registro solicitado.
    fetch(API_TIPO + 'readAll', {
        method: 'get'
    }).then(function (request) {

        // Se verifica si la petición es correcta.
        if (request.ok) {
            request.json().then(function (response) {

                let data = [];
                // Se comprueba si la respuesta es satisfactoria.
                if (response.status) {

                    data = response.dataset;
                    let content = '';
                    data.map(function (row) {

                        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                        content += `
                        <tr>
                        <td>${row.tipo_producto}</td>
                        <td>
                            <a onclick="openUpdateTipo(${row.id_tipo_prod})" data-bs-toggle="modal" data-bs-target="#tipopro-modal">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a onclick="openDeleteTipo(${row.id_tipo_prod})">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                        </tr>
                        `
                    });

                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('tipo-tabla').innerHTML = content;

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Buscador.
function BuscadorTipo(form) {

    // Petición para solicitar los productos.
    fetch(API_TIPO + 'search', {
        method: 'post',
        body: new FormData(document.getElementById(form))
    }).then(function (request) {
        // Se verifica si la petición es correcta.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria.
                if (response.status) {

                    sweetAlert(1, response.message, null);

                    let content = '';
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {

                        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                        content += `
                        <tr>
                        <td>${row.id_tipo_prod}</td>
                        <td>${row.tipo_producto}</td>
                        <td>
                            <a onclick="openUpdateTipo(${row.id_tipo_prod})" data-bs-toggle="modal" data-bs-target="#tipopro-modal">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a onclick="openDeleteTipo(${row.id_tipo_prod})">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                        </tr>
                        `
                    });

                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('tipo-tabla').innerHTML = content;

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Buscador para tipo de productos.
// Método manejador de eventos que se ejecuta cuando se envía el formulario de buscar.
document.getElementById('buscartipo-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se llama a la función que realiza la búsqueda.
    BuscadorTipo('buscartipo-form');
});

// Función para preparar el formulario al momento de insertar un registro.
function openCreateTipo() {

    // Se asigna el título para la caja de diálogo (modal).
    document.getElementById('modal-title').textContent = 'Crear tipo de producto';
}

// Función para preparar el formulario al momento de modificar un registro.
function openUpdateTipo(id) {
    // Se asigna el título para la caja de diálogo (modal).
    document.getElementById('modal-title').textContent = 'Editar tipo de producto';

    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('idt', id);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_TIPO + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se inicializan los campos del formulario con los datos del registro seleccionado.
                    document.getElementById('idt').value = response.dataset.id_tipo_prod;
                    document.getElementById('tipo_nom').value = response.dataset.tipo_producto;

                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de guardar.
document.getElementById('tipo-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se define una variable para establecer la acción a realizar en la API.
    let action = '';
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
    (document.getElementById('idt').value) ? action = 'update' : action = 'create';
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_TIPO, action, 'tipo-form', 'tipopro-modal');
    openShowTipo();
});

// Función para establecer el registro a eliminar y abrir una caja de diálogo de confirmación.
function openDeleteTipo(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('iddt', id);
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
       confirmDelete(API_TIPO, data);
    openShowTipo();
}
// Función para abrir el reporte de productos.
function openReporteMarcas(marcaa) {
    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/reporte_marcas.php?id_marca=' + marcaa;
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}







