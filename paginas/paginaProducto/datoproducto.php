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
//echo $correoUser;
//echo $contraseñaUser;
if ($correoUser == "administrador@gmail.com" && $contraseñaUser == "12345") {
  //  echo "Soy admi";
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
    <title>Datos productos</title>
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
        <form class="Formulario" action="/paginas/paginaProducto/altaproductos.php" method="POST" enctype="multipart/form-data">
            <center>
                <img class="mb-4" src="/imagenes/logo.png" alt="" width="60" height="60">
            </center>
            <h1 class="h3 mb-3 fw-normal text-center">Agregar nuevo producto</h1>
            <input type="text" class="form-control" id="" name="nombreProducto" placeholder="Nombre del producto"
                required>
            <br>
            <input type="text" class="form-control" id="" name="provedor" placeholder="Nombre del proveedor" required>
            <br>
            <b class="b1">Fecha de vencimiento:</b>
            <br>
            <input type="date" class="form-control" id="" name="fechavencimiento" required>
            <br>
            <input type="number" class="form-control" id="" name="preciounitario" placeholder="Precio unitario"
                required>
            <br>
            <input type="number" class="form-control" id="" name="cantidad" placeholder="Cantidad" required>
            <br>
            <input type="text" class="form-control" id="" name="descripcion"
                placeholder="Descripcion" required>
            <br>
            <b class="b1">Selecione imagen del producto:</b>
            <input type="file" class="form-control" id="" name="imagen">
            <br>
            <button class="w-100 btn btn-lg btn-info" type="submit">Agregar</button>
            <center>
                <p class="mt-5 mb-3 text-muted">&copy; 2019–2023</p>
        </form>
        </center>
    </div>
</body>
</html>
