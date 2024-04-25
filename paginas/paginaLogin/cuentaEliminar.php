<?php
include_once("\wamp64\www\ProyectoFarmacia\clases\claseConexion.php");
$correo = "";
$contraseña = "";
$correoUser = "";
$contraseñaUser = "";
$codigoUser = "";
if (empty($_REQUEST["codigoE"])) {
   // echo "Codigo vacio";
    if (empty($_REQUEST["correo"]) || empty($_REQUEST["contraseña"])) {
       // echo "No";
        header("location: /paginas/paginaRegistro/registro.php");
    } else {
      //  echo "Si1";
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
  //  echo "Si2";
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
  //  echo "Soy admi";
    $soyAdmi = true;
} else {
    //echo "No soy admi";
    $soyAdmi = false;
}
//Datos
$objeto = new conexion();
$user = $objeto->TrerUsuario($codigo);
$codigoUser = $user["codigocliente"];
$nombreUser = $user['nombrecliente'];
$apellidopUser = $user['apellidopaterno'];
$apellidomUser = $user['apellidomaterno'];
$ciudadUser = $user['ciudad'];
$direccionUser = $user['direccion'];
$telefonoUser = $user['telefono'];
$correoUser = $user['correoelectronico'];
/*echo "Codigo:", $codigoUser;
echo $nombreUser;
echo $apellidopUser;
echo $apellidomUser;
echo $ciudadUser;
echo $direccionUser;
echo $telefonoUser;
echo $correoUser;*/

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/estilos/estiloIndex.css">
    <link rel="shortcut icon" type="image/x-icon" href="/imagenes/logo.png">
    <link rel="stylesheet" href="/estilos/hover.css">
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--bootstrap---cierre-->
    <!----CSS-->
    <link rel="stylesheet" href="/estilos/estiloregistro.css">
    <title>Inicio</title>
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
                        echo "<li><a href='/paginas/paginaVentas/listaCompras.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Lista de ventas</a>";

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
        <form class="Formulario" action="/paginas/paginaEliminar/eliminarCuenta.php" method="POST">
            <center>
                <img class="mb-4" src="/imagenes/logo.png" alt="" width="60" height="60">
                <h1 class="h3 mb-3 fw-normal text-danger">Esta seguro de eliminar</h1>
                <input type="text" class="w-80 btn btn-lg btn-dark" name="codigo" value="<?php echo $codigoUser ?>">
            </center>
            <br>
            <b>Nombre:</b>
            <input type="text" class="form-control" id="" name="nombre" value="<?php echo $nombreUser ?>"
                placeholder="Nombre" required>
            <br>
            <b>Apellido:</b>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="" name="apellidopaterno"
                    value="<?php echo $apellidopUser ?>" placeholder="Apellido paterno" required>
                <input type="text" class="form-control" id="" name="apellidomaterno"
                    value="<?php echo $apellidomUser ?>" placeholder="Apellido materno" required>
            </div>
            <b>Ciudad:</b>
            <select class="form-select" name="ciudad">
                <?php
                echo $ciudadUser;
                if ($ciudadUser == "Santa cruz") {
                    echo "<option  selected  value='Santa cruz'>Santa cruz</option>;
                <option value='Tarija'>Tarija</option>
                <option value='Cochabamba'>Cochabamba</option>
                <option value='La Paz'>La Paz</option>";
                }
                if ($ciudadUser == "Tarija") {
                    echo "<option value='Santa cruz'>Santa cruz</option>;
                <option selected value='Tarija'>Tarija</option>
                <option value='Cochabamba'>Cochabamba</option>
                <option value='La Paz'>La Paz</option>";
                }
                if ($ciudadUser == "Cochabamba") {
                    echo "<option  value='Santa cruz'>Santa cruz</option>;
                <option value='Tarija'>Tarija</option>
                <option selected value='Cochabamba'>Cochabamba</option>
                <option value='La Paz'>La Paz</option>";
                }
                if ($ciudadUser == "La Paz") {
                    echo "<option  value='Santa cruz'>Santa cruz</option>;
                <option value='Tarija'>Tarija</option>
                <option value='Cochabamba'>Cochabamba</option>
                <option selected value='La Paz'>La Paz</option>";
                }
                ?>
            </select>
            <br>
            <b>Direccion:</b>
            <input type="text" class="form-control" id="" name="direccion" value="<?php echo $direccionUser ?>"
                placeholder="Ingrese su dirección" required>
            <br>
            <b>Telefono:</b>
            <input type="number" class="form-control" id="" name="telefono" value="<?php echo $telefonoUser ?>"
                placeholder="Ingrese su telefono" required>
            <br>
            <b>Correro Electronico:</b>
            <input type="email" class="form-control" id="" name="correo" value="<?php echo $correoUser ?>"
                placeholder="Usuario@gmail.com" disabled required>
            <br>
            <b>Contraseña:</b>
            <input type="password" class="form-control" id="" name="contraseña" value="*********"
                placeholder="Contraseña" disabled required>
            <br>
            <center>
                <div class='btn-group' role='group' aria-label='Basic mixed styles example'>
                <?php
                echo "<button class='w-100 btn btn-lg btn-danger' type='submit'>Si</button>";
                echo "<a href='/paginas/indexUsuario.php?codigoE=$codigoUser'> <input type ='button' class='btn btn-lg btn-success' value = 'No'></input></a>";   
                ?>
                </div>
            </center>            
            <p class="mt-5 mb-3 text-muted">&copy; 2019–2023</p>
        </form>
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