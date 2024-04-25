<?php
//----Datos Productos
include("/wamp64/www/ProyectoFarmacia/clases/login/conexion.php");
$query = "select * from trabajador";
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
    <link rel="stylesheet" href="/estilos/estiloIndex.css">
    <link rel="stylesheet" href="/estilos/hover.css">
    <link rel="shortcut icon" type="image/x-icon" href="/imagenes/logo.png">
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--bootstrap---cierre-->
    <link rel="stylesheet" href="/estilos/listas.css">
    <title>Trabajadores</title>
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
    <?php
    if ($soyAdmi) {
        echo " <br><div class='container py-3 fs-5'>     
        <a href='/paginas/paginaTrabajador/datostrabajador.php?codigoE=$codigo''><button type='button' class='btn btn-success'>Agregar nuevo trabajador
        </button></a>
        </div>";
    }
    ?>
    <div class="container">
        <h1>Lista de trabajadores</h1>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">C.I</th>
                    <th scope="col">Correo Electronico</th>
                     <th scope="col"></th>
                    <th scope="col"></th>
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
            while ($row = $resultado->fetch_assoc()) {
                $_Codigo = $row['codigotrabajador'];
                $_Nombre = $row['nombretrabajador'];
                $_Telefono = $row['telefono'];
                $_ci = $row['ci'];
                $_Correoelectronico = $row['correoelectronico'];
                $sw = ColorCelda($sw);
                echo "
                <tr>
                    <th scope='row'>$_Codigo </th>
                    <td>$_Nombre </td>
                    <td>$_Telefono </td>
                    <td>$_ci </td>                   
                    <td>$_Correoelectronico</td>
                    <td> 
                    <a href='/paginas/paginaTrabajador/modificarTrabajador.php?codigoP=$_Codigo&codigoE=$codigo'> 
                    <img class='rounded img-fluid' width = '60px' height: '50px'  src='/imagenes/modificar.png'></a> </td> 
                    <td>
                    <a href='/paginas/paginaTrabajador/eliminarTrabajador.php?codigoP=$_Codigo&codigoE=$codigo'>
                    <img class='rounded img-fluid' width = '60px' height: '50px' src='/imagenes/eliminar.png'></a>  </td>         
                </tr>
            </tbody>";
            }
            ?>       
        </table>
    </div>
    <br><br><br><br>
    <br><br><br><br>
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