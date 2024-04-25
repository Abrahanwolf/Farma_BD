<?php
$codigoproducto = $_REQUEST["codigo"];
include_once("\wamp64\www\ProyectoFarmacia\clases\claseProducto.php");
$objeto = new producto();
$objeto->EliminarProducto($codigoproducto);
$saltar = true;
if ($saltar) {
    header("location:/paginas/paginaProducto/producto.php?codigoE=1");
}
?>