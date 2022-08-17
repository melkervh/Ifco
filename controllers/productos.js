// Constantes para establecer las rutas y parámetros de comunicación con la API.
const API_PRODUCTOS = SERVER + 'Actions/productos.php?action=';
const ENDPOINT_CATEGORIAS = SERVER + 'Actions/marcas.php?action=readAll';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows(API_PRODUCTOS);
    // Se define una variable para establecer las opciones del componente Modal.
    let options = {
        dismissible: false,
        onOpenStart: function () {
            // Se restauran los elementos del formulario.
            document.getElementById('productosmo').reset();
        }
    }
});

// Función para llenar la tabla con los datos de los registros. Se manda a llamar en la función readRows().
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se establece un icono para el estado del producto.
        (row.estado_producto) ? icon = 'visibility' : icon = 'visibility_off';
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
            <tr>
               <td>${row.id_producto}</td>
                <td>${row.nombre_prodroducto}</td>
                <td>${row.cantidad_prodroducto}</td>
                <td>${row.descripcion_producto}</td>
                <td>${row.estado_producto}</td>
                <td>${row.precio_unidad}</td>
                <td>${row.id_marca}</td>
                <td>
                    <a onclick="openUpdate(${row.id_producto})"class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tipopro">
                      <i class="fa-solid fa-pen"></i>
                    </a>
                    <a onclick="openDelete(${row.id_producto})" class="btn-floating waves-effect red tooltipped" data-tooltip="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </td>
            </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('producto').innerHTML = content;
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de buscar.
document.getElementById('buscaa').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se llama a la función que realiza la búsqueda. Se encuentra en el archivo components.js
    searchRows(API_PRODUCTOS, 'buscaa');
});

// Función para preparar el formulario al momento de insertar un registro.
function openCreate() {
    // Se asigna el título para la caja de diálogo (modal).
    document.getElementById('modal-title').textContent = 'Crear producto';
    // Se establece el campo de archivo como obligatorio.
    document.getElementById('archivo').required = true;
    // Se llama a la función que llena el select del formulario. Se encuentra en el archivo components.js
    fillSelect(ENDPOINT_CATEGORIAS, 'categoria', null);
}

// Función para abrir el reporte de productos.
function openReport() {
    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/dashboard/productos.php';
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}

// Función para preparar el formulario al momento de modificar un registro.
function openUpdate(id) {
    // Se asigna el título para la caja de diálogo (modal).
    document.getElementById('modal-title').textContent = 'Actualizar producto';
    // Se establece el campo de archivo como opcional.
    document.getElementById('archivo').required = false;
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_PRODUCTOS + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se inicializan los campos del formulario con los datos del registro seleccionado.
                    document.getElementById('id').value = response.dataset.id_producto;
                    document.getElementById('nombre').value = response.dataset.nombre_producto;
                    document.getElementById('precio').value = response.dataset.precio_producto;
                    document.getElementById('descripcion').value = response.dataset.descripcion_producto;
                    fillSelect(ENDPOINT_CATEGORIAS, 'categoria', response.dataset.id_categoria);
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
document.getElementById('save-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se define una variable para establecer la acción a realizar en la API.
    let action = '';
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_PRODUCTOS, action, 'save-form', 'save-modal');
});

// Función para establecer el registro a eliminar y abrir una caja de diálogo de confirmación.
function openDelete(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id', id);
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete(API_PRODUCTOS, data);
}
