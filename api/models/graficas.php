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
    public function readProductosCategoria()
    {
        $sql = 'SELECT idproducto, img_producto, nombre_producto, descripcion_producto, precio_produc
        FROM producto INNER JOIN tipo_produc USING(idtip)
        WHERE idtip = ? AND estado_producto = true
        ORDER BY nombre_producto';
        $params = array($this->idproducto);
        return Database::getRows($sql, $params);
    }
   

}