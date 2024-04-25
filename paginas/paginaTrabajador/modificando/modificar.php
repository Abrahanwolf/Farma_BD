<?php
$codigo = $_REQUEST["codigo"];
$nombreTrabajador = $_REQUEST["nombreTrabajador"];
$telefono = $_REQUEST["telefono"];
$ci = $_REQUEST["ci"];
$correo = $_REQUEST["correo"];
include_once("\wamp64\www\ProyectoFarmacia\clases\claseTrabajador.php");
$objeto = new trabajador();
$objeto->ModificarTrabajador(
    $codigo,
    $nombreTrabajador,
    $telefono,
    $ci,
    $correo,
);
$saltar = true;
if ($saltar) {
    header("location:/paginas/paginaTrabajador/trabajador.php?codigoE=1");
}
?>