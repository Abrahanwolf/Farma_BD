<?php
//----Datos Productos
include("/wamp64/www/ProyectoFarmacia/clases/login/conexion.php");
$query = "select * from producto ORDER BY codigoproducto";
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
   // echo "Soy admi";
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
    <title>Productos</title>
    <style>
        b{
            color: rgb(27, 175, 168);
        }
    </style>
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
                    echo "<li><a href='/paginas/listaClientes/clientes.php?codigoE=$codigo' class='nav-link px-2 text-white'>Clientes</a>";
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
        <a href='/paginas/paginaProducto/datoproducto.php?codigoE=$codigo''><button type='button' class='btn btn-success'>Agregar nuevo
        producto</button></a>
        </div>";
    }
    ?>
    <!---Alamacen de datos-->
    <div class="container py-3 fs-5">
        <h2 class="display-6 text-center mb-4">Productos disponibles</h2>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            <?php
            while ($row = $resultado->fetch_assoc()) {
                $_codigo = $row['codigoproducto'];
                $_nombre = $row['nombreproducto'];
                $_proveedor = $row['proveedor'];
                $_fechavencimiento = $row['fechavencimiento'];
                $_preciounitario = $row['preciounitario'];
                $_cantidad = $row['cantidad'];
                $_descripcion = $row['descripcion'];
                $_imagen = $row['imagen'];
                ?>
                <?php
                echo "<div class='col'>
                      <div class='card mb-4 rounded-3 shadow-sm border-info'>
                      <div class='card-header py-3 text-white bg-info border-info'>
                      <h4 class='my-0 fw-normal'>Codigo Producto: $_codigo</h4>
                      </div>
                      <div class='card-body'>";
                ?>
                <img width="200" height="200"  class="img-fluid img-thumbnail" src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>">
                <?php
                echo "
                      <br><br>
                      <h1 class='card-title pricing-card-title fs-3'> $_preciounitario bs</h1>
                      <ul class='list-unstyled mt-3 mb-4'>
                      <li><b>Producto:</b> $_nombre</li>
                      <li><b>Proveedor:</b>  $_proveedor</li>
                      <li><b>Stock: </b> $_cantidad unidades</li>
                      <li><b>Fecha de vencimiento:</b>  $_fechavencimiento</li>
                      <li><b>Descripcion: </b>  $_descripcion</li>
                      </ul>";
                      if($soyAdmi){
                        echo "<center>
                        <div class='btn-group' role='group' aria-label='Basic mixed styles example'>
                        <a href='/paginas/paginaProducto/modificarProducto.php?codigoP=$_codigo&codigoE=$codigo'> 
                        <img class='rounded img-fluid' width = '60px' height: '50px'  src='/imagenes/modificar.png'></a> 
                        <a href='/paginas/paginaProducto/eliminarProducto.php?codigoP=$_codigo&codigoE=$codigo'> 
                        <img class='rounded img-fluid' width = '60px' height: '50px' src='/imagenes/eliminar.png'></a>  
                        </div>
                        </center>";
                      }
                      else{
                        if($_cantidad > 0)
                        {
                        echo "<a href='/paginas/paginaVentas/ventas.php?codigoP=$_codigo&codigoE=$codigo''> 
                        <input type ='button' class='w-100 btn btn-lg btn-info text-white' value = 'Comprar'></input></a> ";
                        }
                        else{
                        echo "<a href='#'> 
                        <input type ='button' class='w-100 btn btn-lg btn-dark' value = 'Agotado'></input></a> ";
                        }

                      }
                    echo
                    "</div>
                    </div>
                      </div>";
            } ?>
        </div>
    </div>
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