<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<!---Favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="/imagenes/logo.png">
<!--------->
<!----CSS-->
<link rel="stylesheet" href="/estilos/estiloregistro.css">
<title>Registro</title>
</head>
<body>   
    <div class="container sm">
            <form class="Formulario" action="/paginas/paginaregistro/altasregistro.php" method="POST" >
                <center>
                <img class="mb-4" src="/imagenes/logo.png" alt="" width="60" height="60">
                <h1 class="h3 mb-3 fw-normal">Registro de nuevo usuario</h1>
                </center>
                <input type="text" class="form-control" id="" name="nombre" placeholder="Ingresa tu nombre" required>
                <br>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="" name="apellidopaterno" placeholder="Apellido paterno"
                        required>
                    <input type="text" class="form-control" id="" name="apellidomaterno" placeholder="Apellido materno"
                        required>
                </div>
                <b>Ciudad:</b>
                <select class="form-select" name="ciudad">
                    <option value="Santa cruz">Santa cruz</option>
                    <option value="Tarija">Tarija</option>
                    <option value="Cochamba">Cochamba</option>
                    <option value="La Paz">La Paz</option>
                </select>
                <br>
                <input type="text" class="form-control" id="" name="direccion" placeholder="Ingrese su dirección"
                    required>
                    <br>
                <input type="number" class="form-control" id="" name="telefono" placeholder="Ingrese su telefono"
                    required>
                    <br>
                <input type="email" class="form-control" id="" name="correo" placeholder="Usuario@gmail.com" required>
                <br>
                <input type="password" class="form-control" id="" name="contraseña" placeholder="Contraseña" required>
                <br>
                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="recordar">Recordar 
                    </label>
                </div>
                    <button class="w-100 btn btn-lg btn-info" type="submit">Registrarse</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2019–2023</p>
    </form>
    </div>
</body>

</html>