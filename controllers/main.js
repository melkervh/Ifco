// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_GRAFICA = SERVER + 'Actions/graficos.php?action=';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {

    // se de declaran las variables con las que se muestran las graficas 

    // grafica de productos disponibles 
    graficoBarrasProducto();

    // grrafica de ventas  por mes sobre factura y credito 
    ventaspormes();

    // grafico de estados de productos 
    estadoproducto();

    //grafico de porcentaje de productos por categoria 
    graficoPastelCategorias();

    // grafica de productos mas vendidos 
    productosMasVendidos();

    // grafica de clientes con mas compras 
    clientesConmasCompras();
});

// grafica que muestra el top con los 10 productos con mas existencias 
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
                    barGraph('chart1', categoria, cantidades, 'Cantidad de productos', 'Top 10 productos con mas existencias');
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

// grafica que muestra las ventas por  mes 
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

/// grafico con la cantidad de productos disponibles y agotados 
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
                    pieGraph2 ('chart7', categoria, cantidades, 'Lista de estado productos');
                } else {
                    document.getElementById('chart7').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

//grafico con la cantidad de productos por marca
function graficoPastelCategorias() {
    // Petición para obtener los datos del gráfico.
    fetch(API_GRAFICA + 'porcentajeProductosCategoria', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a gráficar.
                    let categorias = [];
                    let porcentajes = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        categorias.push(row.marca);
                        porcentajes.push(row.porcentaje);
                    });
                    // Se llama a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
                polarArea('chart4', categorias, porcentajes, 'Porcentaje de productos por categoría');
                } else {
                    document.getElementById('chart4').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// top con los productos mas vendidos 
function productosMasVendidos() {
    // Petición para obtener los datos del gráfico.
    fetch(API_GRAFICA + 'productosMasVendidos', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo +contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a gráficar.
                    let producto = [];
                    let ventas = [];
                    // Se recorre el conjunto de registro devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {+
                        // Se agregan los datos a los arreglos.
                        producto.push(row.nombre_prodroducto);
                        ventas.push(row.vendidos);
                    });
                    // Se llama a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
                    barGraph2('chart6', producto, ventas,'Productos más vendidos', 'Top 10 productos más vendidos');
                } else {
                    document.getElementById('chart6').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}
function clientesConmasCompras() {
    // Petición para obtener los datos del gráfico.
    if(document.getElementById('ventas').value == 1){

    fetch(API_GRAFICA +'clientesconmascompras', {
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
                        id_fiscal.push(row.compras);
                        fecha_credito.push(row.nombre_cli);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    barGraph3('chart3', fecha_credito, id_fiscal, 'ventas', 'top 5 clientes con mas compras');
                } else {
                    document.getElementById('chart3').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
    document.getElementById('ventas').value = 0 ;
  }
  else if (document.getElementById('ventas').value == 0){
    fetch(API_GRAFICA +'clientesconmascomprasCre', {
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
                        id_fact_nor.push(row.compras);
                        fecha_fn.push(row.nombre_cli);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    barGraph3('chart3',  fecha_fn , id_fact_nor, 'ventas', 'top 5 clientes con mas compras en credito fiscal');
                } else {
                    document.getElementById('chart3').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
    document.getElementById('ventas').value = 1 ;
  }
}

