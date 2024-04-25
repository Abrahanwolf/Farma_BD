<?php
$nombreCliente = $_REQUEST["nombre"];
$apellidoPaterno = $_REQUEST["apellidopaterno"];
$apellidoMaterno = $_REQUEST["apellidomaterno"];
$ciudad = $_REQUEST["ciudad"];
$direcion = $_REQUEST["direccion"];
$telefono = $_REQUEST["telefono"];
$correo = $_REQUEST["correo"];
$contraseña = $_REQUEST["contraseña"];
include_once("\wamp64\www\ProyectoFarmacia\clases\claseConexion.php");
$objeto = new conexion();
$objeto->AltasClientes(
    $nombreCliente,
    $apellidoPaterno,
    $apellidoMaterno,
    $ciudad,
    $direcion,
    $telefono,
    $correo,
    $contraseña
);
$saltar = true;
if ($saltar) {
    header("location: /clases/login/loginsalir.php");
}