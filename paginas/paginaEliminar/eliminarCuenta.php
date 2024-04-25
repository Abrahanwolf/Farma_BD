<?php
$codigoCliente = $_REQUEST["codigo"];
include_once("\wamp64\www\ProyectoFarmacia\clases\claseConexion.php");
$objeto = new conexion();
$objeto->EliminarCuenta($codigoCliente);
$saltar = true;
if ($saltar) {
    header("location: /clases/login/loginsalir.php");
}
?>