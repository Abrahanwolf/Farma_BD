<?php
$codigoCliente = $_REQUEST["codigo"];
$nombreCliente = $_REQUEST["nombre"];
$apellidoPaterno = $_REQUEST["apellidopaterno"];
$apellidoMaterno = $_REQUEST["apellidomaterno"];
$ciudad = $_REQUEST["ciudad"];
$direcion = $_REQUEST["direccion"];
$telefono = $_REQUEST["telefono"];
include_once("\wamp64\www\ProyectoFarmacia\clases\claseConexion.php");
$objeto = new conexion();
$objeto->ModificarCuenta($codigoCliente,$nombreCliente,$apellidoPaterno,$apellidoMaterno,$ciudad,$direcion,$telefono);
$saltar = true;
if ($saltar) {
    header("location: /paginas/indexUsuario.php?codigoE=$codigoCliente");
}
?>