<?php
include_once("\wamp64\www\ProyectoFarmacia\clases\claseConexion.php");
$correo = "";
$contraseña = "";
$correoUser = "";
$contraseñaUser = "";
$codigoUser = "";
if (empty($_REQUEST["codigoE"])) {
    //echo "Codigo vacio";
    if (empty($_REQUEST["correo"]) || empty($_REQUEST["contraseña"])) {
        //echo "No";
        header("location: /paginas/paginaRegistro/registro.php");
    } else {
        //echo "Si1";
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
    /*echo "Codigo no vacio";
    echo "Si2";*/
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
//echo $correoUser;
//echo $contraseñaUser;
if ($correoUser == "administrador@gmail.com" && $contraseñaUser == "12345") {
   // echo "Soy admi";
    $soyAdmi = true;
} else {
    //echo "No soy admi";
    $soyAdmi = false;
}

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
    <title>Inicio</title>
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
                    echo "<li><a href='/paginas/indexUsuario.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Inicio</a></li>";
                    echo "<li><a href='/paginas/paginaProducto/producto.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Productos</a>";
                    if ($soyAdmi) {
                        echo "<li><a href='/paginas/listaClientes/clientes?codigoE=$codigoUser' class='nav-link px-2 text-white'>Clientes</a>";
                        echo "<li><a href='/paginas/paginaTrabajador/trabajador.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Trabajadores</a>";
                        echo "<li><a href='/paginas/paginaVentas/listaCompras.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Lista de ventas</a>";
                        echo "<li><a href='/paginas/paginaReporte/reporte.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Reportes</a>";
                    }
                    else{
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
    <br>
    <center>
        <h1 class="h1">Farmaweb El gato</h1>
    </center>
    <!--Carrusel-->
    <br>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"
                aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4"
                aria-label="Slide 5"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5"
                aria-label="Slide 6"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/imagenes/carrusel/carrusel_1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/imagenes/carrusel/carrusel_2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/imagenes/carrusel/carrusel_3.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/imagenes/carrusel/carrusel_4.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/imagenes/carrusel/carrusel_5.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/imagenes/carrusel/carrusel_6.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!--Carrusel----Cierre-->
    <br>
    <br>
    <section>
        <!--Article---->
        <article>
            <div class="container py-5">
                <center>
                    <h1 class="h1">Proveedores</h1>
                </center>
                <div class="row py-5 row-cols-3 row-cols-lg-6">
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/babaria.jpg" alt="">
                    </div>
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/durex.jpg" alt="">
                    </div>
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/eucerin.jpg" alt="">
                    </div>
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/gillette.jpg" alt="">
                    </div>
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/kotex.jpg" alt="">
                    </div>
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/head-Shoulders.jpg" alt="">
                    </div>
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/nivea.jpg" alt="">
                    </div>
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/s-c-johnson-son.jpg" alt="">
                    </div>
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/huggies.jpg" alt="">
                    </div>
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/nosotras.jpg" alt="">
                    </div>
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/kleenex.jpg" alt="">
                    </div>
                    <div class="feature-icon">
                        <img src="/imagenes/marcas/clearmen.jpg" alt="">
                    </div>
                </div>
            </div>
            </div>
        </article>
        <!--Article--cierre-->
    </section>

    <!--aside---->
    <aside>
        <div class="container py-1">
            <center>
                <h4>
                    <span class="text-info">Siguenos en nuestras redes</span>
                </h4>
                <br>
                <div class="row py-2 row-cols-4 row-cols-lg-4">
                    <a class="link" href="http://www.facebook.com" target="blank">
                        <img src="/imagenes/redessociales/facebook.png"  width=50 height=50>
                        <h3 class="text-info"> Faccebook</h3>
                    </a>
                    <a class="link" href="http://www.instagram.com" target="blank">
                        <img src="/imagenes/redessociales/instagram.png" width=50 height=50>
                        <h3 class="text-info"> Instagram</h3>
                    </a>
                    <a class="link" href="http://www.twitter.com" target="blank">
                        <img src="/imagenes/redessociales/twitter.png" width=50 height=50>
                        <h3 class="text-info"> Twitter</h3>
                    </a>
                    <a class="link" href="http://www.youtube.com" target="blank">
                        <img src="/imagenes/redessociales/youtube.png" width=50 height=50>
                        <h3 class="text-info"> Youtube</h3>
                    </a>
                </div>
            </center>
    </aside>
    <!--aside--cierre-->
    <br><br><br><br><br>
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