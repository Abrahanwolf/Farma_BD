<?php
$codigoproducto = $_REQUEST["codigo"];
$nombreProducto = $_REQUEST["nombreProducto"];
$provedor = $_REQUEST["provedor"];
$fechavencimiento = $_REQUEST["fechavencimiento"];
$preciounitario = $_REQUEST["preciounitario"];
$cantidad = $_REQUEST["cantidad"];
$descripcion = $_REQUEST["descripcion"];
$imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

include_once("\wamp64\www\ProyectoFarmacia\clases\claseProducto.php");
$objeto = new producto();
$objeto->ModificarProductos($codigoproducto, $nombreProducto, $provedor, 
$fechavencimiento, $preciounitario,$cantidad, $descripcion, $imagen);
$saltar = true;
if ($saltar) {
    header("location:/paginas/paginaProducto/producto.php?codigoE=1");
}
?>