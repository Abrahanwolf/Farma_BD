<?php
$codigo = $_REQUEST["codigo"];
include_once("\wamp64\www\ProyectoFarmacia\clases\claseTrabajador.php");
$objeto = new trabajador();
$objeto->EliminarTrabajador($codigo,);
$saltar = true;
if ($saltar) {
    header("location:/paginas/paginaTrabajador/trabajador.php?codigoE=1");
}
?>