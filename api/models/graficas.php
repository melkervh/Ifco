 <?php
 
class Graficos extends Validator{
    
 public function productosconmas()
    {
        $sql = 'SELECT nombre_prodroducto,cantidad_prodroducto 
        FROM producto 
        ORDER BY cantidad_prodroducto DESC 
        limit 10';
        $params = null;
        return Database::getRows($sql, $params);
    }
    public function ventapormesfac()
    {
        $sql = "SELECT COUNT(id_fact_nor) AS cantidad, to_char(fecha_fn, 'TMMonth') 
        AS nombre_mes, to_char(fecha_fn, 'mm') AS numero_mes
        FROM factura_normal
        WHERE to_char(fecha_fn,'yy') = to_char(CURRENT_DATE,'yy')
        GROUP BY nombre_mes, numero_mes
        ORDER BY numero_mes";
        $params = null;
        return Database::getRows($sql, $params);
    }
    public function ventapormescre()
    {
        $sql = "SELECT COUNT(id_fiscal) AS cantidad, to_char(fecha_credito, 'TMMonth') 
            AS nombre_mes, to_char(fecha_credito, 'mm') AS numero_mes
            FROM credito_fiscal
            WHERE to_char(fecha_credito,'yy') = to_char(CURRENT_DATE,'yy')
            GROUP BY nombre_mes, numero_mes
            ORDER BY numero_mes";
        $params = null;
        return Database::getRows($sql, $params);
    }
     public function estadoproducto()
    {
        $sql = "SELECT count(id_producto) as cantidad, CASE estado_producto 
        WHEN true THEN 'Disponible'
        WHEN false THEN 'Agotado'
        END AS estado
        FROM producto 
        GROUP BY estado_producto 
        ORDER BY estado_producto DESC";
        $params = null;
        return Database::getRows($sql, $params);
    }
   

    public function porcentajeProductosCategoria()
    {
        $sql = 'SELECT marca, ROUND((COUNT(id_producto) * 100.0 / (SELECT COUNT(id_producto) FROM producto)), 2) porcentaje
        FROM producto INNER JOIN marca USING(id_marca)
        GROUP BY marca ORDER BY porcentaje DESC';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function clienteDepartamento()
    {
        $sql = 'SELECT id_cliente, departamento
        FROM cliente 
        ORDER BY departamento DESC';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function productosMasVendidos()
    {
        $sql = 'SELECT nombre_prodroducto, sum(id_producto) AS vendidos
        FROM detalle_factura inner JOIN producto USING (id_producto)
        GROUP BY nombre_prodroducto  order by  vendidos desc ';
        $params = null;
        return Database::getRows($sql, $params);
    }
}