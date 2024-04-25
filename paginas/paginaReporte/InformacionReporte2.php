<?php
$Fec1 = $_REQUEST['fecha1'];
$Fec2 = $_REQUEST['fecha2'];


include_once("\wamp64\www\ProyectoFarmacia\clases\claseReporte.php");

$Obj = new reporte();
$Obj->MostrarInformacion2($Fec1, $Fec2);

?>