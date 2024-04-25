<?php
//----Datos Productos
class conexion
{
    ///Conexion------------------------------------->
    public function Conectando()
    {
        return mysqli_connect("localhost", "root", "", "bdfarmawebelgato");
    }
    public function AltasClientes($nombreclien, $apellidopater, $apellidomater, $ciud, $direcc, $telef, $correoelectro, $contrasena)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............AltasClientes");
        $sql = "insert into cliente (nombrecliente, apellidopaterno, 
            apellidomaterno, ciudad, direccion,telefono,correoelectronico, 
          contrasena) values ('$nombreclien','$apellidopater','$apellidomater','$ciud', '$direcc' 
        ,$telef, '$correoelectro','$contrasena');";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............AltasClientes");
        mysqli_close($Conexion);
    }
    ///Conexion------------------------------------->Cierre

    public function Verificar($correo, $contraseña)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............");
        $sql = "select codigocliente, correoelectronico, contrasena from cliente where correoelectronico = '$correo'
        and contrasena = '$contraseña'";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............");
        $Tabla = mysqli_query($Conexion, $sql) or die("Problema de Ejecucion tabla");
        $registro = mysqli_fetch_array($Tabla);
        mysqli_close($Conexion);
        return $registro;
    }
    public function TrerUsuario($codigo)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............");
        $sql = "select codigocliente, nombrecliente, apellidopaterno,  apellidomaterno, ciudad, direccion,telefono, correoelectronico, contrasena from cliente where codigocliente = '$codigo'";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............");
        $Tabla = mysqli_query($Conexion, $sql) or die("Problema de Ejecucion tabla");
        $registro = mysqli_fetch_array($Tabla);
        mysqli_close($Conexion);
        return $registro;
    }
    public function ModificarCuenta($codigo, $nombreclien, $apellidopater, $apellidomater, $ciud, $direcc, $telef)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............");
        $sql = "update cliente set nombrecliente = '$nombreclien', apellidopaterno = '$apellidopater', 
       apellidomaterno = '$apellidomater', ciudad = '$ciud', direccion= '$direcc',
       telefono= '$telef'  where codigocliente = '$codigo'";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............");
        mysqli_close($Conexion);
    }
    public function EliminarCuenta($codigo)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............");
        $sql = "delete  from cliente where codigocliente = '$codigo'";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............");
        mysqli_close($Conexion);
    }
}
?>