// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_GRAFICA = SERVER + 'Actions/graficos.php?action=';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se define un objeto con la fecha y hora actual.
    graficoBarrasProducto();
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
                    pieGraph('chart1', categoria, cantidades, 'Cantidad de productos', 'top 10 productos con mas stok');
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

// Función para mostrar el porcentaje de productos por categoría en un gráfico de pastel.
