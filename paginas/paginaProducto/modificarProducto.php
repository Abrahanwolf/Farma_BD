<?php
include_once("\wamp64\www\ProyectoFarmacia\clases\claseProducto.php");
//Datos
$objeto = new producto();
$codigo = $_REQUEST["codigoP"];
$produc = $objeto->TrerProducto($codigo);

$codigoProdu = $produc["codigoproducto"];
$nombreProdu = $produc['nombreproducto'];
$proveedorProduc = $produc['proveedor'];
$fechavencimientoProduc = $produc['fechavencimiento'];
$precioProduc = $produc['preciounitario'];
$cantidadProdu = $produc['cantidad'];
$descripcionProduc = $produc['descripcion'];
$imagenProduc = $produc['imagen'];
/*echo "Codigo:", $codigoProdu;
echo $nombreProdu;
echo $proveedorProduc;
echo $precioProduc;
echo $cantidadProdu;
echo $descripcionProduc;*/
?>
<?php
//----Datos Productos
include("/wamp64/www/ProyectoFarmacia/clases/login/conexion.php");
$query = "select * from producto";
$resultado = $conexion->query($query);

//Verificar Usuario Admi
include_once("\wamp64\www\ProyectoFarmacia\clases\claseConexion.php");
$codigo = $_REQUEST["codigoE"];
$objeto = new conexion();
$user = $objeto->TrerUsuario($codigo);
$correoUser = $user['correoelectronico'];
$contraseñaUser = $user['contrasena'];
$soyAdmi = false;
/*echo $correoUser;
echo $contraseñaUser;*/
if ($correoUser == "administrador@gmail.com" && $contraseñaUser == "12345") {
    //echo "Soy admi";
    $soyAdmi = true;
} else {
   // echo "No soy admi";
    $soyAdmi = false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="/imagenes/logo.png">
    <link rel="stylesheet" href="/estilos/hover.css">
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--bootstrap---cierre-->
    <link rel="stylesheet" href="/estilos/estiloagregarproductos.css">
    <title>Modificar</title>
</head>
<style>
    b {
        font-size: 15px;
    }

    p {
        font-size: 15px;
    }
</style>
<body>
    <!--Header-->
    <header class="p-3 bg-info text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="/imagenes/logo.png" alt="" width="60" height="60" role="img">
                </a>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <?php
                    echo "<li><a href='/paginas/indexUsuario.php?codigoE=$codigo' class='nav-link px-2 text-white'>Inicio</a></li>";
                    echo "<li><a href='/paginas/paginaProducto/producto.php?codigoE=$codigo' class='nav-link px-2 text-white'>Productos</a>";
                    if ($soyAdmi) {
                        echo "<li><a href='/paginas/listaClientes/clientes?codigoE=$codigo' class='nav-link px-2 text-white'>Clientes</a>";
                        echo "<li><a href='/paginas/paginaTrabajador/trabajador.php?codigoE=$codigo' class='nav-link px-2 text-white'>Trabajadores</a>";
                        echo "<li><a href='/paginas/paginaVentas/listaCompras.php?codigoE=$codigo' class='nav-link px-2 text-white'>Lista de ventas</a>";
                        echo "<li><a href='/paginas/paginaReporte/reporte.php?codigoE=$codigo' class='nav-link px-2 text-white'>Reportes</a>";


                    } else {
                        echo "<li><a href='/paginas/paginaLogin/cuenta.php?codigoE=$codigo' class='nav-link px-2 text-white'>Cuenta</a>";
                    }
                    ?>
                </ul>
                <div class="text-end">
                    <?php
                    echo "<a href='#' class='btn btn-light me-2'>Bienvenido $correoUser</a>";
                    echo "<a href='/clases/login/loginsalir.php' class='btn btn-outline-light me-2'>Cerrar sesion</a>"
                        ?>
                </div>
            </div>
        </div>
    </header>
    <div class="container sm">
        <form class="Formulario" action="/paginas/paginaProducto/modifcando/modificar.php" method="POST"enctype="multipart/form-data">
            <center>
                <img class="mb-4" src="/imagenes/logo.png" alt="" width="60" height="60">
                <h1 class="h3 mb-3 fw-normal text-center">Modificar producto</h1>
                <input type="text" class="w-80 btn btn-lg btn-dark" name="codigo" value="<?php echo $codigoProdu ?>">
                <br><br>
            </center> 
            <b class="b1">Nombre:</b>       
            <input type="text" class="form-control" id="" name="nombreProducto" value="<?php echo $nombreProdu ?>" placeholder="Nombre del producto"
                required>
            <br>
            <b class="b1">Proveedor:</b>
            <input type="text" class="form-control" id="" name="provedor"value="<?php echo $proveedorProduc ?>" placeholder="Nombre del proveedor" required>
            <br>
            <b class="b1">Fecha de vencimiento:</b>
            <br>
            <input type="date" class="form-control" id="" name="fechavencimiento" value="<?php echo $fechavencimientoProduc ?>" required>
            <br>
            <b class="b1">Precio:</b>
            <input type="number" class="form-control" id="" name="preciounitario"value="<?php echo $precioProduc ?>" placeholder="Precio unitario"
                required>
            <br>
            <b class="b1">Cantidad:</b>
            <input type="number" class="form-control" id="" name="cantidad" value="<?php echo $cantidadProdu ?>" placeholder="Cantidad" required>
            <br>
            <b class="b1">Descripción:</b>
            <input type="text" class="form-control" id="" name="descripcion" value="<?php echo $descripcionProduc ?>" placeholder="Cantidad" required>
            <br>
            <b class="b1">Anterior imagen:</b>
            <center>
            <img width="100" height="100" src="data:image/jpg;base64,<?php echo base64_encode($imagenProduc); ?>" >
            </center>
            <br>
            <b class="b1">Selecione nueva imagen:</b>
            <input type="file" class="form-control" id="" name="imagen" required>
            <br>
            <button class="w-100 btn btn-lg btn-success" type="submit">Modificar</button>
            <center>
                <p class="mt-5 mb-3 text-muted">&copy; 2019–2023</p>
        </form>
        </center>
    </div>
</body>

</html>