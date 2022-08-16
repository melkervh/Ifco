// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_GRAFICA = SERVER + 'Actions/graficos.php?action=';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se define un objeto con la fecha y hora actual.
    graficoBarrasProducto();
    ventaspormes();
    estadoproducto();
});

// Función para mostrar la cantidad de productos por categoría en un gráfico de barras.
function graficoBarrasProducto() {
    // Petición para obtener los datos del gráfico.
    fetch(API_GRAFICA +'topstockproductos', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                    let categoria = [];
                    let cantidades = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        categoria.push(row.nombre_prodroducto);
                        cantidades.push(row.cantidad_prodroducto);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    barGraph('chart1', categoria, cantidades, 'Cantidad de productos', 'top 10 productos con mas existencias');
                } else {
                    document.getElementById('chart1').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}
function ventaspormes() {
    // Petición para obtener los datos del gráfico.
    if(document.getElementById('factu').value == 1){

    fetch(API_GRAFICA +'ventaspormescre', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                    let id_fiscal = [];
                    let fecha_credito = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        id_fiscal.push(row.cantidad);
                        fecha_credito.push(row.nombre_mes);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    lineGraph1('chart2', fecha_credito, id_fiscal, 'ventas', 'cantidad de facturas credito fiscal por mes');
                } else {
                    document.getElementById('chart2').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
    document.getElementById('factu').value = 0 ;
  }
  else if (document.getElementById('factu').value == 0){
    fetch(API_GRAFICA +'ventaspormesfac', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                    let fecha_fn = [];
                    let id_fact_nor = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        id_fact_nor.push(row.cantidad);
                        fecha_fn.push(row.nombre_mes);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    lineGraph1('chart2',  fecha_fn , id_fact_nor, 'ventas', 'cantidad de facturas por mes');
                } else {
                    document.getElementById('chart2').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
    document.getElementById('factu').value = 1 ;
  }
}
// Función para mostrar el porcentaje de productos por categoría en un gráfico de pastel.
// Función para mostrar la cantidad de productos por categoría en un gráfico de barras.
function estadoproducto() {
    // Petición para obtener los datos del gráfico.
    fetch(API_GRAFICA +'estadoproducto', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                    let categoria = [];
                    let cantidades = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        categoria.push(row.estado);
                        cantidades.push(row.cantidad);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    pieGraph('chart3', categoria, cantidades, 'Lista de estado productos');
                } else {
                    document.getElementById('chart3').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}
