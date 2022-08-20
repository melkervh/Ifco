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