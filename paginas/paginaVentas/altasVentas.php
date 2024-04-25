<?php
$codigoventa = $_REQUEST["codigoventa"];
$fechaventa = $_REQUEST["fechaventa"];
$precioventa = $_REQUEST["precioventa"];
$cantidad = $_REQUEST["cantidad"];
$codigocliente = $_REQUEST["codigocliente"];
$codigoproducto = $_REQUEST["codigoproducto"];
$codigotrabajador = $_REQUEST["codigotrabajador"];


include_once("\wamp64\www\ProyectoFarmacia\clases\claseVentas.php");
include_once("\wamp64\www\ProyectoFarmacia\clases\claseProducto.php");
$objeto = new conexionVentas();
$objeto->AltasVentas( $fechaventa, $precioventa, $cantidad, $codigocliente, $codigoproducto, $codigotrabajador);


$objCantidad = new producto();
$productoCantidad = $objCantidad->TrerProducto($codigoproducto);
$cantidadProducActual = $productoCantidad["cantidad"];
$modificar = new producto();
$restaCantidad = $cantidadProducActual - $cantidad;
$modificar->ModificarStock($codigoproducto,$restaCantidad);
echo "<script>
alert('Gracias por su compra')
window.location = '/paginas/paginaProducto/producto.php?codigoE=$codigocliente'
</script>';";

?>
