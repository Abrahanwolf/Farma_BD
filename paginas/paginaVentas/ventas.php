<?php
include_once("\wamp64\www\ProyectoFarmacia\clases\claseConexion.php");
include_once("\wamp64\www\ProyectoFarmacia\clases\claseProducto.php");
include_once("\wamp64\www\ProyectoFarmacia\clases\claseVentas.php");
include_once("\wamp64\www\ProyectoFarmacia\clases\claseTrabajador.php");
$correo = "";
$contraseña = "";
$correoUser = "";
$contraseñaUser = "";
$codigoUser = "";
if (empty($_REQUEST["codigoE"])) {
  //  echo "Codigo vacio";
    if (empty($_REQUEST["correo"]) || empty($_REQUEST["contraseña"])) {
    //    echo "No";
        header("location: /paginas/paginaRegistro/registro.php");
    } else {
    //    echo "Si1";
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
  //  echo "Codigo no vacio";
   // echo "Si2";
    $codigo = $_REQUEST["codigoE"];
    $codigoProc = $_REQUEST["codigoP"];
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
  //  echo "No soy admi";
    $soyAdmi = false;
}
//Datos
$objeto = new conexion();
$user = $objeto->TrerUsuario($codigo);
$codigoUser = $user["codigocliente"];

$objeto1 = new producto();
$producto = $objeto1->TrerProducto($codigoProc);
$codigoProducto = $producto["codigoproducto"];
$precioProduc = $producto['preciounitario'];
$cantidadProdu = $producto['cantidad'];
$nombreProduc = $producto['nombreproducto'];
$imagenProduc = $producto['imagen'];

$objeto2 = new trabajador();
$trabajador = $objeto2->TraerTrabajador();
$codigoTrabajador = $trabajador["codigotrabajador"];

$objeto4 = new conexionVentas();
$codigoVenta = $objeto4->TraerCodigoVenta();
$fechaActual = date('Y/m/d');
//echo $fechaActual;
if ($codigoVenta == null) {
    $codigoVenta = 1;
}


include("/wamp64/www/ProyectoFarmacia/clases/login/conexion.php");
$query = "select * from trabajador";
$resultado = $conexion->query($query);
?>
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
    <!----CSS-->
    <link rel="stylesheet" href="/estilos/estiloregistro.css">
    <title>Ventas</title>
</head>
<style>
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
                    echo "<li><a href='/paginas/indexUsuario.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Inicio</a></li>";
                    echo "<li><a href='/paginas/paginaProducto/producto.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Productos</a>";
                    if ($soyAdmi) {
                        echo "<li><a href='/paginas/listaClientes/clientes?codigoE=$codigoUser' class='nav-link px-2 text-white'>Clientes</a>";
                    } else {
                        echo "<li><a href='/paginas/paginaLogin/cuenta.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Cuenta</a>";
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
    <div class="container sm">
        <form class="Formulario" action="/paginas/paginaVentas/altasVentas" method="POST"id="form_costo4" oninput="<?php echo "result4.value=parseInt(cantidad.value)* $precioProduc "; ?>">
            <center>
                <img class="mb-4" src="/imagenes/logo.png" alt="" width="60" height="60">
                <h1 class="h3 mb-3 fw-normal">Codigo venta<input type="text" class="w-80 btn btn-lg btn-dark"
                        name="codigoventa" value="<?php echo $codigoVenta ?>"></h1>
            </center>
            <br>
            <b>Codigo Cliente:</b>
            <input type="number" class="form-control" id="" name="codigocliente" value="<?php echo $codigoUser ?>"
                placeholder="Ingrese su codigo" required>
            <b>Codigo Producto:</b>
            <input type="number" class="form-control" id="" name="codigoproducto" value="<?php echo $codigoProducto ?>"
                placeholder="Codigo producto" required>
            <b>Nombre producto:</b>
            <input type="text" class="form-control" id="" name="fechaventa" value="<?php echo $nombreProduc ?>"
                placeholder="Fecha" required>
            <b>Fecha Venta:</b>
            <input type="text" class="form-control" id="" name="fechaventa" value="<?php echo $fechaActual ?>"
                placeholder="Fecha" required>
            <b>Precio por unidad:</b>
            <input type="number" class="form-control" id="" name="precioventa" value="<?php echo $precioProduc ?>"
                placeholder="Precio" required>
            <b>Cantidad:</b>
            <select class="form-select" name="cantidad">
                <option value="0" selected disabled required>0</option>
                <?php
                $i = 1;
                while ($i <= $cantidadProdu) {
                    echo "<option value='$i'>$i</option>";
                    $i++;
                }
                ?>
            </select>
            <b>Encargado de la entrega:</b>
            <select class="form-select" name="codigotrabajador">
                <?php
                while ($row = $resultado->fetch_assoc()) {
                    $codigoTrabajador = $row["codigotrabajador"];
                    $nombre = $row["nombretrabajador"];
                    echo "<option value='$codigoTrabajador'>$nombre</option>";
                }
                ?>
            </select>
            <br>
            <b class="b1">Imagen del producto:</b>
            <center>
                <img width="100" height="100" src="data:image/jpg;base64,<?php echo base64_encode($imagenProduc); ?>">
            </center>
            <br>
            <h5 class="b1" >Total: <output form='form_costo4' name='result4' for='costo4'></output> bs</h5>
            <br>     
            <center>
                <div class='btn-group' role='group' aria-label='Basic mixed styles example'>
                    <?php
                    echo "<a href='#'?codigoE=$codigoUser'> <input type ='submit' class='btn btn-lg btn-success' value = 'Comprar'></input></a>";
                    echo "<a href='/paginas/paginaProducto/producto?codigoE=$codigoUser'> <input type ='button' class='btn btn-lg btn-danger' value = 'Cancelar'></input></a>";
                    ?>
                </div>
            </center>
            <p class="mt-5 mb-3 text-muted">&copy; 2019–2023</p>
        </form>
    </div>
    </form>


    <hr>
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