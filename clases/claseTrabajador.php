<?php
class trabajador
{
    ///Conexion------------------------------------->
    public function Conectando()
    {
        return mysqli_connect("localhost", "root", "", "bdfarmawebelgato");
    }
    public function AltasTrabajadores($nombrepro, $telefono, $ci, $correo)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............AltasProductos");
        $sql = "insert into trabajador (nombretrabajador, telefono, 
        ci, correoelectronico) 
        values ('$nombrepro','$telefono','$ci','$correo')";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............AltasProductos");
        mysqli_close($Conexion);
    }
    public function TraerTrabajador()
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............AltasProductos");
        $sql = "select codigotrabajador, nombretrabajador, telefono,  ci, correoelectronico from trabajador";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............");
        $Tabla = mysqli_query($Conexion, $sql) or die("Problema de Ejecucion tabla");
        $registro = mysqli_fetch_array($Tabla);
        mysqli_close($Conexion);
        return $registro;
    }
    public function TraerCodigoTrabajador($codigo)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............AltasProductos");
        $sql = "select codigotrabajador, nombretrabajador, telefono,  ci, correoelectronico from trabajador where codigotrabajador = '$codigo'";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............");
        $Tabla = mysqli_query($Conexion, $sql) or die("Problema de Ejecucion tabla");
        $registro = mysqli_fetch_array($Tabla);
        mysqli_close($Conexion);
        return $registro;
    }
    public function ModificarTrabajador($codigo, $nombreTrabajador, $telefono, $ci, $correo)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............");
        $sql = "update trabajador set nombretrabajador = '$nombreTrabajador', telefono = '$telefono', 
       ci = '$ci', correoelectronico = '$correo' where codigotrabajador = '$codigo'";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............ModificarTrabajador");
        mysqli_close($Conexion);
    }
    public function EliminarTrabajador($codigo)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion...............");
        $sql = "delete  from trabajador where codigotrabajador = '$codigo'";
        mysqli_query($Conexion, $sql) or die("Problema de Ejecucion query............");
        mysqli_close($Conexion);
    }
}
?>