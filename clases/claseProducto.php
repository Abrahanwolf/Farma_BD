<?php
class producto
{
    ///Conexion------------------------------------->
    public function Conectando()
    {
        return mysqli_connect("localhost", "root", "", "bdfarmawebelgato");
    }

    public function AltasProductos($nombrepro, $nombreprove, $fec, $prec, $canti, $descrip, $img)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............AltasProductos");
        $sql = "insert into producto (nombreproducto, proveedor, 
        fechavencimiento, preciounitario,cantidad,descripcion,imagen) 
        values ('$nombrepro','$nombreprove','$fec','$prec',
        '$canti' ,'$descrip','$img')";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............AltasProductos");
        mysqli_close($Conexion);
    }

    public function TrerProducto($codigo)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............");
        $sql = "select codigoproducto, nombreproducto, proveedor, 
        fechavencimiento, preciounitario, cantidad,descripcion, imagen from producto where codigoproducto = '$codigo'";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............");
        $Tabla = mysqli_query($Conexion, $sql) or die("Problema de Ejecucion tabla");
        $registro = mysqli_fetch_array($Tabla);
        mysqli_close($Conexion);
        return $registro;
    }
    public function ModificarProductos($codigo, $nombreproducto, $proveedor, $fecha, $precio, $cantidad, $descripcion, $imagen)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............");
        $sql = "update producto set nombreproducto = '$nombreproducto', proveedor = '$proveedor', 
       fechavencimiento = '$fecha', preciounitario = '$precio', cantidad= '$cantidad', descripcion= '$descripcion',
       imagen= '$imagen'  where codigoproducto = '$codigo'";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............");
        mysqli_close($Conexion);
    }
    public function EliminarProducto($codigo)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............");
        $sql = "delete  from producto where codigoproducto = '$codigo'";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............");
        mysqli_close($Conexion);
    }
    public function ModificarStock($codigoprod_,$canti_)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............");
        $sql = "update producto set cantidad= '$canti_'  where codigoproducto = '$codigoprod_'";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............");
        mysqli_close($Conexion);
    }
}
?>