<?php
include_once("\wamp64\www\ProyectoFarmacia\clases\claseConexion.php");
include_once("\wamp64\www\ProyectoFarmacia\clases\claseReporte.php");
$correo = "";
$contraseña = "";
$correoUser = "";
$contraseñaUser = "";
$codigoUser = "";
if (empty($_REQUEST["codigoE"])) {
    // echo "Codigo vacio";
    if (empty($_REQUEST["correo"]) || empty($_REQUEST["contraseña"])) {
        //  echo "No";
        header("location: /paginas/paginaRegistro/registro.php");
    } else {
        // echo "Si1";
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
    /* echo "Codigo no vacio";
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
/*echo $correoUser;
echo $contraseñaUser;*/
if ($correoUser == "administrador@gmail.com" && $contraseñaUser == "12345") {
    //   echo "Soy admi";
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
    <link rel="stylesheet" href="/estilos/estiloIndex.css">
    <link rel="shortcut icon" type="image/x-icon" href="/imagenes/logo.png">
    <link rel="stylesheet" href="/estilos/hover.css">
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--bootstrap---cierre-->
    <title>Reportes</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", { packages: ["corechart"] });
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                <?php
                //----Datos Productos
                include("/wamp64/www/ProyectoFarmacia/clases/login/conexion.php");
                $query = "SELECT month(fechaventa)as MesVenta, COUNT(*) as cantidadVentaMes,
                SUM(precioventa) as SumaTotal, AVG(precioventa) as Promedio 
                FROM venta
                GROUP BY month(fechaventa)
                ORDER BY fechaventa ASC";
                $Obj = new reporte();
                $resultado = $conexion->query($query);
                while ($row = $resultado->fetch_assoc()) {
                    $_mes = $row['MesVenta'];
                    $_cantidad = $row['cantidadVentaMes'];
                    $_mes =  $Obj->queMesSoy($_mes);        
                    echo "['$_mes', $_cantidad],";
                }
                ?>
            ]);
            var options = {
                title: 'Cantidad de ventas mensuales',
                pieHole: 0.4,
            };
            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>
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
                    if ($soyAdmi) {
                        echo "<li><a href='/paginas/paginaReporte/reporte.php?codigoE=$codigoUser'  class='nav-link px-2 text-white'>Reportes</a>";
                        // echo "<li><a href='/paginas/paginaReporte/reporteRodrigo.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Reportes Rodrigo</a>";
                        // echo "<li><a href='/paginas/paginaReporte/reporteRony.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Reportes Rony</a>";
                        //echo "<li><a href='/paginas/paginaReporte/reporteAbrahan.php?codigoE=$codigoUser' class='nav-link px-2 text-white'>Reportes Abrahan</a>";
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
    <br>
    <center>
        <h1 class="h1">Reportes Farmaweb el gato</h1>
    </center>
    <!--Carrusel-->
    <br>
    <div class="container">
        <center>
            <div id="donutchart" style="width: 900px; height: 500px;"></div>
            <center>
                <main>
                    <div class="row row-cols-1 row-cols-md-4 mb-4 text-center">
                        <div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm border-info">
                                <div class="card-header py-3 text-white bg-info border-info">
                                    <h4 class="my-0 fw-normal">Reporte Rodrigo</h4>
                                </div>
                                <div class="card-body">
                                    <img class="img-thumbnail" src="/imagenes/reportes.jpg" alt="">
                                    <?php echo "<a href='/paginas/paginaReporte/reporteRodrigo.php?codigoE=$codigoUser'>
                            <button type='button' class='w-100 btn btn-lg btn-info'>Ingresar</button>
                            </a>" ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm border-info">
                                <div class="card-header py-3 text-white bg-info border-info">
                                    <h4 class="my-0 fw-normal">Reporte Rony</h4>
                                </div>
                                <div class="card-body">
                                    <img class="img-thumbnail" src="/imagenes/reportes.jpg" alt="">
                                    <?php echo "<a href='/paginas/paginaReporte/reporteRony.php?codigoE=$codigoUser' >
                            <button type='button' class='w-100 btn btn-lg btn-info'>Ingresar</button>
                            </a>" ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm border-info">
                                <div class="card-header py-3 text-white bg-info border-info">
                                    <h4 class="my-0 fw-normal">Reporte Abrahan</h4>
                                </div>
                                <div class="card-body">
                                    <img class="img-thumbnail" src="/imagenes/reportes.jpg" alt="">
                                    <?php echo "<a href='/paginas/paginaReporte/reporteAbrahan.php?codigoE=$codigoUser'>
                            <button type='button' class='w-100 btn btn-lg btn-info'>Ingresar</button>
                            </a>" ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm border-info">
                                <div class="card-header py-3 text-white bg-info border-info">
                                    <h4 class="my-0 fw-normal">Reporte con Grafica</h4>
                                </div>
                                <div class="card-body">
                                    <img class="img-thumbnail" src="/imagenes/reportes.jpg" alt="">
                                    <?php echo "<a href='/paginas/paginaReporte/reporteAdicional.php?codigoE=$codigoUser'>
                            <button type='button' class='w-100 btn btn-lg btn-info'>Ingresar</button>
                            </a>" ?>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
    <br><br> <br><br>
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