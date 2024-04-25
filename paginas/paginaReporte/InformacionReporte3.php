<?php
$nombreProducto = $_REQUEST['nombreproducto'];
//echo $nombreProducto;
include_once("\wamp64\www\ProyectoFarmacia\clases\claseReporte.php");

$Obj = new reporte();
$Obj->MostrarInformacion3($nombreProducto);
?>