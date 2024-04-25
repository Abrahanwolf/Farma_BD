<?php
//----Datos Productos
include_once("\wamp64\www\ProyectoFarmacia\clases\claseVentas.php");
//Verificar Usuario Admi
include_once("\wamp64\www\ProyectoFarmacia\clases\claseConexion.php");
$correo = "";
$contraseña = "";
$correoUser = "";
$contraseñaUser = "";
$codigoUser = "";
if (empty($_REQUEST["codigoE"])) {
    //echo "Codigo vacio";
    if (empty($_REQUEST["correo"]) || empty($_REQUEST["contraseña"])) {
        //  echo "No";
        header("location: /paginas/paginaRegistro/registro.php");
    } else {
        echo "Si1";
        $correo = $_REQUEST["correo"];
        $contraseña = $_REQUEST["contraseña"];
        $objeto = new conexion();
        $user = $objeto->Verificar($correo, $contraseña);
        if (empty($user)) {
            header("location: /paginas/paginaRegistro/registro.php");
        } else {
            $correoUser = $user['correoelectronico'];
            $contraseñaUser = $user['contrasena'];
            $codigoUser = $user['codigocliente'];
        }
    }
} else {
    // echo "Codigo no vacio";
    //echo "Si2";
    $codigo = $_REQUEST["codigoE"];
    $objeto = new conexion();
    $user = $objeto->TrerUsuario($codigo);
    $correoUser = $user['correoelectronico'];
    $contraseñaUser = $user['contrasena'];
    $user = $objeto->Verificar($correoUser, $contraseñaUser);
    if (empty($user)) {
        header("location: /paginas/paginaRegistro/registro.php");
    } else {
        $codigoUser = $user['codigocliente'];
    }
}
$soyAdmi = false;
/*echo $correoUser;
echo $contraseñaUser;*/
if ($correoUser == "administrador@gmail.com" && $contraseñaUser == "12345") {
    // echo "Soy admi";
    $soyAdmi = true;
} else {
    // echo "No soy admi";
    $soyAdmi = false;
}
?>
<style>
    .container {
        font-size: 20px;
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/estilos/estiloIndex.css">
    <link rel="stylesheet" href="/estilos/hover.css">
    <link rel="shortcut icon" type="image/x-icon" href="/imagenes/logo.png">
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--bootstrap---cierre-->
    <title>Lista compras</title>
</head>

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
                        echo "<li><a href='/paginas/paginaVentas/listaCompras.php?codigoE=$codigo' class='nav-link px-2 text-white'>Lista de compras</a>";
                        echo "<li><a href='/paginas/paginaLogin/cuenta.php?codigoE=$codigo' class='nav-link px-2 text-white'>Cuenta</a>";
                    }
                    ?>
                </ul>
                <div class="text-end">
                    <?php
                    session_start();
                    echo "<a href='#' class='btn btn-light me-2'>Bienvenido $correoUser</a>";
                    echo "<a href='/clases/login/loginsalir.php' class='btn btn-outline-light me-2'>Cerrar sesion</a>"
                        ?>
                </div>
            </div>
        </div>
    </header>
    <!--Header----Cierre-->
    <div class="container">
        <div class="table-responsive">
        <h1>Lista de compras</h1>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Codigo de venta</th>
                    <th scope="col">Fecha de la compra</th>
                    <th scope="col">Nombre de cliente</th>
                    <th scope="col">Nombre Producto</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Encargado de la entrega</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <?php
            function ColorCelda($sw)
            {
                if ($sw == 0) {
                    echo "<tbody class='table-white'>";
                    $sw = 1;
                } else {
                    echo "<tbody class='table-info'>";
                    $sw = 0;
                }
                return $sw;
            }
            $sw = 0;
            $Obj1 = new conexionVentas();
            $Tabla = $Obj1->TraerVentaDatos();
            while ($row = mysqli_fetch_array($Tabla)) {
                $_Codigoventa = $row['codigoventa'];
                $_Fechaventa = $row['fechaventa'];
                $_PrecioVenta = $row['precioventa'];
                $_Cantidad = $row['cantidadProduc'];
                $_CodigoCliente = $row['nombreClien'];
                $_CodigoProducto = $row['nombreProducto'];
                $_CodigoTrabajador = $row['Encargador'];
                $totalVenta = $_PrecioVenta * $_Cantidad;
                $sw = ColorCelda($sw);
                echo "
                <tr>
                    <th scope='row'>$_Codigoventa </th>
                    <td>$_Fechaventa </td>
                    <td>$_CodigoCliente </td>
                    <td>$_CodigoProducto </td>
                    <td>$_PrecioVenta bs</td>
                    <td>$_Cantidad </td>       
                    <td>$_CodigoTrabajador</td>    
                    <td> $totalVenta bs</td>     
                </tr>
            </tbody>";
            }
            ?>
        </table>
    </div>
        </div>
    <!--Footer---->
    <footer class="p-3 bg-dark text-white">
        <center>
            <p class="float-end"><a href="#" class="text-info">Ir arriba</a></p>
            <p>&copy; 2019–2023 FarmawebElgato, Inc. &middot; <a href="#" class="text-info">Privacidad</a> &middot; <a
                    href="#" class="text-info">Términos</a>
            </p>
        </center>
    </footer>
    <!--Footer--cierre-->
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>

<!--<td class = 'd-grid gap-2 d-md-flex justify-content-md-end'>
<button type='button' class='btn btn-danger'>Eliminar</button></td>-->