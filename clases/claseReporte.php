<?php
class reporte
{
    ///Conexion------------------------------------->
    public function Conectando()
    {
        return mysqli_connect("localhost", "root", "", "bdfarmawebelgato");
    }

    ///-----------Reporte Rodrigo
    public function MostrarInformacion1($Fec1, $Fec2)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion");
        $sql = "SELECT DAY(fechaventa)as fecVenta, COUNT(*) as cantidadVentaDia,
         SUM(precioventa) as SumaTotal, AVG(precioventa) as Promedio 
         FROM venta Where fechaventa BETWEEN '$Fec1' AND '$Fec2'
          GROUP BY DAY(fechaventa)
           ORDER BY SUM(precioventa) DESC;";
        $Tabla = mysqli_query($Conexion, $sql) or die("Problema de Ejecucion Informacion 1");
        mysqli_close($Conexion);
        $this->Reporte1V1($Tabla, $Fec1, $Fec2);
    }

    public function Reporte1V1($Tabla, $fec1, $fec2)
    {
        include_once('\wamp64\www\ProyectoFarmacia\fpdf\fpdf.php');
        $Obj = new FPDF('L', 'mm', 'legal');
        //Orientacion de la Pagina, unidad de medida, tamaño.

        $Fec = new DateTime(date("d-m-Y H:i"));
        $FecAct = $Fec->format('d-m-Y H:i:s');

        $Sw = 0;
        $Total = 0;
        $ConPag = 1;
        $Obj->AddPage();

        $Obj->SetFont('Arial', 'B', 14);
        $Obj->SetFillColor(44, 255, 245);
        $Obj->SetTextColor(0, 0, 0);
        //Ancho, Alto, Texto o Variable, bordes, Salto de lineas, Alineado, Rellenado.
        $Obj->cell(100, 10, "Pagina: " . $ConPag, 'L', 0, 'C', true);
        $Obj->cell(240, 10, "Fecha y Hora: " . $FecAct, 'R', 0, 'C', true);
        $Obj->Ln();

        $Obj->SetFont('Arial', 'B', 18);
        $Obj->cell(340, 10, "REPORTE DE VENTAS POR DIA DESDE FECHA" . $fec1 . "HASTA " . $fec2, 'B', 0, 'C', true);
        //Ancho, Alto, Texto o Variable, bordes, Salto de lineas, Alineado, Rellenado.
        $Obj->Image('C:\wamp64\www\ProyectoFarmacia\imagenes\logo.png', 10, 10, 20, 20);
        //Columna Superior Izquierda, Fila Superior, Ancho, Alto
        $Obj->Ln();

        $Obj->SetFont('Arial', 'B', 11);
        $Obj->SetFillColor(209, 217, 217);
        $Obj->SetTextColor(0, 0, 0);

        $Obj->Cell(85, 10, "Dia de venta", 'B', 0, 'L', true);
        $Obj->Cell(85, 10, "Total de venta por dia", 'B', 0, 'L', true);
        $Obj->Cell(85, 10, "Suma total por dia", 'B', 0, 'L', true);
        $Obj->Cell(85, 10, "Promedio por dia", 'B', 0, 'L', true);

        $Obj->Ln();

        while ($reg = mysqli_fetch_array($Tabla)) {
            $Fec = $reg['fecVenta'];
            $CantidadDia = $reg['cantidadVentaDia'];
            $SumaDia = $reg['SumaTotal'];
            $PromedioDia = $reg['Promedio'];
            if ($Sw == 0) {
                $Obj->SetFillColor(255, 255, 255);
                $Sw = 1;
            } else {
                $Obj->SetFillColor(154, 243, 227);
                $Sw = 0;
            }
            //Ancho, Alto, Texto o Variable, bordes, Salto de lineas, Alineado, Rellenado.
            $Obj->Cell(85, 10, $Fec, 'B', 0, 'L', true);
            $Obj->Cell(85, 10, $CantidadDia, 'B', 0, 'L', true);
            $Obj->Cell(85, 10, $SumaDia, 'B', 0, 'L', true);
            $Obj->Cell(85, 10, number_format($PromedioDia, 2), 'B', 0, 'L', true);
            $Obj->Ln();

            $Total += $SumaDia;
        }
        $Obj->SetFont('Arial', 'B', 18);
        $Obj->Ln();
        $Obj->Ln();
        $Obj->Cell(320, 20, "Total Cobrado Bs: " . number_format($Total), 'B', 5, 'C', true);

        $Obj->Output();
    }
    ///-------------------REPORTE RONY
    public function MostrarInformacion2($Fec1, $Fec2)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion");
        $sql = "select codigoventa,producto.nombreproducto as nombreProducto,cliente.nombrecliente as nombreClien, 
        trabajador.nombretrabajador as Encargador,producto.cantidad as cantidadProduc,fechaventa,precioventa from venta INNER JOIN producto ON venta.codigoproducto = producto.codigoproducto INNER JOIN trabajador ON venta.codigotrabajador = trabajador.codigotrabajador INNER JOIN cliente ON
        venta.codigocliente = cliente.codigocliente
        Where fechaventa BETWEEN '$Fec1' AND '$Fec2'
        order by cliente.nombrecliente";
        $Tabla = mysqli_query($Conexion, $sql) or die("Problema de Ejecucion Informacion 1");

        /*select codigoventa,producto.nombreproducto as nombreProducto,cliente.nombrecliente as nombreClien, 
        trabajador.nombretrabajador as Encargador,producto.cantidad as cantidadProduc,fechaventa,precioventa from venta INNER JOIN producto ON venta.codigoproducto = producto.codigoproducto INNER JOIN trabajador ON venta.codigotrabajador = trabajador.codigotrabajador INNER JOIN cliente ON
        venta.codigocliente = cliente.codigocliente*/

        mysqli_close($Conexion);
        $this->Reporte1V2($Tabla, $Fec1, $Fec2);
    }

    public function Reporte1V2($Tabla, $Fec1, $Fec2)
    {
        include_once('\wamp64\www\ProyectoFarmacia\fpdf\fpdf.php');

        $Obj = new FPDF('L', 'mm', 'legal');
        //Orientacion de la Pagina, unidad de medida, tamaño.
        $ConPag = 0;
        $Fec = new DateTime(date("d-m-Y H:i"));
        $FecAct = $Fec->format('d-m-Y H:i:s');

        $tituloAnterior = "";
        $Sw = 0;
        $Acu = 0;
        $AcuSubTot = 0;
        $anterior = 0;
        $total = 0;
        while ($reg = mysqli_fetch_array($Tabla)) {
            $Cod = $reg[0];
            $Fec = $reg[5];
            $NomCli = $reg[2];
            $NomPro = $reg['nombreProducto'];
            $Pre = $reg['precioventa'];
            $Can = $reg['cantidadProduc'];
            $Enc = $reg[3];
            if ($NomCli != $tituloAnterior) {
                if ($ConPag != 0) { //MOSTRAR EL SUB TOTAL
                    $Obj->Ln();
                    $Obj->SetFont('Arial', 'B', 16);
                    $Obj->SetTextColor(0, 0, 0);
                    $Obj->SetFillColor(44, 255, 245);
                    $Obj->Cell(350, 20, "Sub Total Comision Bs.: " . number_format($AcuSubTot), 'B', 5, 'C', true);
                    $anterior += $AcuSubTot;
                    $AcuSubTot = 0;
                }
                $Obj->AddPage();
                $ConPag++;

                $Obj->SetFont('Arial', 'B', 14);
                $Obj->SetFillColor(44, 255, 245);
                $Obj->SetTextColor(62, 40, 39);
                $Obj->cell(100, 10, "Pagina: " . $ConPag, 'L', 0, 'C', true);
                $Obj->cell(240, 10, "Fecha y Hora: " . $FecAct, 'R', 0, 'C', true);
                $Obj->Ln();

                $Obj->SetFont('Arial', 'B', 18);
                $Obj->cell(340, 10, "REPORTE DE VENTA DESDE " . $Fec1 . " HASTA " . $Fec2, 'B', 0, 'C', true);
                //Ancho, Alto, Texto o Variable, bordes, Salto de lineas, Alineado, Rellenado.
                $Obj->Image('C:\wamp64\www\ProyectoFarmacia\imagenes\logo.png', 10, 10, 20, 20);
                //Columna Superior Izquierda, Fila Superior, Ancho, Alto
                $Obj->Ln();

                $Obj->SetFillColor(255, 253, 196);
                $Obj->cell(340, 12, "Nombre del cliente: " . $NomCli, 'B', 0, 'C', true);
                $Obj->Ln();

                $Obj->SetFont('Arial', 'B', 11);
                $Obj->SetFillColor(209, 217, 217);
                $Obj->SetTextColor(0, 0, 0);

                $Obj->Cell(45, 10, "Codigo de venta", 'B', 0, 'L', true);
                $Obj->Cell(45, 10, "Fecha de la compra", 'B', 0, 'L', true);
                $Obj->Cell(45, 10, "Nombre de cliente", 'B', 0, 'L', true);
                $Obj->Cell(45, 10, "Nombre Producto", 'B', 0, 'L', true);
                $Obj->Cell(45, 10, "Precio", 'B', 0, 'L', true);
                $Obj->Cell(70, 10, "Cantidad", 'B', 0, 'L', true);
                $Obj->Cell(45, 10, "Encargado de la entrega", 'B', 0, 'L', true);

                $Obj->Ln();
            }
            $Obj->SetFont('Arial', 'B', 11);
            $Obj->SetTextColor(42, 26, 26);
            if ($Sw == 0) {
                $Obj->SetFillColor(255, 255, 255);
                $Sw = 1;
            } else {
                $Obj->SetFillColor(154, 243, 227);
                $Sw = 0;
            }
            //Ancho, Alto, Texto o Variable, bordes, Salto de lineas, Alineado, Rellenado.
            $Obj->Cell(45, 10, $Cod, 'B', 0, 'L', true);
            $Obj->Cell(45, 10, $Fec, 'B', 0, 'L', true);
            $Obj->Cell(45, 10, $NomCli, 'B', 0, 'L', true);
            $Obj->Cell(45, 10, $NomPro, 'B', 0, 'L', true);
            $Obj->Cell(45, 10, $Pre, 'B', 0, 'L', true);
            $Obj->Cell(70, 10, $Can, 'B', 0, 'L', true);
            $Obj->Cell(45, 10, $Enc, 'B', 0, 'L', true);
            $Obj->Ln();

            $Acu = $Pre * $Can;
            $AcuSubTot += $Acu;
            $tituloAnterior = $NomCli;
        }
        $anterior += $AcuSubTot;
        $total = $anterior;
        $Obj->Ln();
        $Obj->SetFont('Arial', 'B', 18);
        $Obj->SetTextColor(0, 0, 0);
        $Obj->SetFillColor(44, 255, 245);
        $Obj->Cell(340, 20, "Sub Total Comision Bs.: " . number_format($AcuSubTot), 'B', 5, 'C', true);
        $Obj->Ln();
        $Obj->Ln();
        $Obj->Ln();
        $Obj->Ln();
        $Obj->Cell(340, 20, "Total Cobrado Bs.: " . number_format($total), 'B', 5, 'C', true);

        $Obj->Output();
    }
    ///---------------REPORTE ABRAHAN
    public function MostrarInformacion3($nombrePro)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion");
        $sql = "select codigoventa,producto.nombreproducto as nombreProducto,cliente.nombrecliente as nombreClien, 
        trabajador.nombretrabajador as Encargador,producto.cantidad as cantidadProduc,fechaventa,precioventa from venta INNER JOIN producto ON venta.codigoproducto = producto.codigoproducto INNER JOIN trabajador ON venta.codigotrabajador = trabajador.codigotrabajador INNER JOIN cliente ON
        venta.codigocliente = cliente.codigocliente
        Where  producto.nombreproducto = '$nombrePro'
        order by cliente.nombrecliente";
        $Tabla = mysqli_query($Conexion, $sql) or die("Problema de Ejecucion Informacion 3");
        mysqli_close($Conexion);
        $reg = mysqli_fetch_array($Tabla);
        if ($reg > 0) {
            $this->Reporte1V3($Tabla, $nombrePro);
        } else {

            header("location: /paginas/paginaReporte/reporteAbrahan.php?codigoE=1");
        }

    }
    public function Reporte1V3($Tabla, $nombrePro)
    {
        include_once('\wamp64\www\ProyectoFarmacia\fpdf\fpdf.php');

        $Obj = new FPDF('L', 'mm', 'legal');
        //Orientacion de la Pagina, unidad de medida, tamaño.
        $ConPag = 0;
        $Fec = new DateTime(date("d-m-Y H:i"));
        $FecAct = $Fec->format('d-m-Y H:i:s');

        $tituloAnterior = "";
        $Sw = 0;
        $Acu = 0;
        $AcuSubTot = 0;
        $anterior = 0;
        $total = 0;
        while ($reg = mysqli_fetch_array($Tabla)) {
            $Cod = $reg[0];
            $Fec = $reg[5];
            $NomCli = $reg[2];
            $NomPro = $reg['nombreProducto'];
            $Pre = $reg['precioventa'];
            $Can = $reg['cantidadProduc'];
            $Enc = $reg[3];
            $Total = ($Pre * $Can);
            if ($NomCli != $tituloAnterior) {
                if ($ConPag != 0) { //MOSTRAR EL SUB TOTAL
                    $Obj->Ln();
                    $Obj->SetFont('Arial', 'B', 16);
                    $Obj->SetTextColor(0, 0, 0);
                    $Obj->SetFillColor(44, 255, 245);
                    $Obj->Cell(340, 20, "Sub Total Comision Bs.: " . number_format($AcuSubTot), 'B', 5, 'C', true);
                    $anterior += $AcuSubTot;
                    $AcuSubTot = 0;
                }
                $Obj->AddPage();
                $ConPag++;

                $Obj->SetFont('Arial', 'B', 14);
                $Obj->SetFillColor(44, 255, 245);
                $Obj->SetTextColor(62, 40, 39);
                $Obj->cell(100, 10, "Pagina: " . $ConPag, 'L', 0, 'C', true);
                $Obj->cell(240, 10, "Fecha y Hora: " . $FecAct, 'R', 0, 'C', true);
                $Obj->Ln();

                $Obj->SetFont('Arial', 'B', 18);
                $Obj->cell(340, 10, "Reporte de:  " . $nombrePro, 'B', 0, 'C', true);
                //Ancho, Alto, Texto o Variable, bordes, Salto de lineas, Alineado, Rellenado.
                //$Obj->Image('..\imagenes\logo.png',10,10,30,25);  
                //Columna Superior Izquierda, Fila Superior, Ancho, Alto
                $Obj->Ln();

                $Obj->SetFillColor(255, 253, 196);
                $Obj->cell(340, 12, "Nombre del cliente: " . $NomCli, 'B', 0, 'C', true);
                $Obj->Ln();

                $Obj->SetFont('Arial', 'B', 11);
                $Obj->SetFillColor(209, 217, 217);
                $Obj->SetTextColor(0, 0, 0);

                $Obj->Cell(45, 10, "Codigo de venta", 'B', 0, 'L', true);
                $Obj->Cell(45, 10, "Fecha de la compra", 'B', 0, 'L', true);
                $Obj->Cell(45, 10, "Nombre de cliente", 'B', 0, 'L', true);
                $Obj->Cell(45, 10, "Nombre Producto", 'B', 0, 'L', true);
                $Obj->Cell(45, 10, "Precio", 'B', 0, 'L', true);
                $Obj->Cell(70, 10, "Cantidad", 'B', 0, 'L', true);
                $Obj->Cell(45, 10, "Encargado de la entrega", 'B', 0, 'L', true);

                $Obj->Ln();
            }
            $Obj->SetFont('Arial', 'B', 11);
            $Obj->SetTextColor(42, 26, 26);
            if ($Sw == 0) {
                $Obj->SetFillColor(255, 255, 255);
                $Sw = 1;
            } else {
                $Obj->SetFillColor(154, 243, 227);
                $Sw = 0;
            }
            //Ancho, Alto, Texto o Variable, bordes, Salto de lineas, Alineado, Rellenado.
            $Obj->Cell(45, 10, $Cod, 'B', 0, 'L', true);
            $Obj->Cell(45, 10, $Fec, 'B', 0, 'L', true);
            $Obj->Cell(45, 10, $NomCli, 'B', 0, 'L', true);
            $Obj->Cell(45, 10, $NomPro, 'B', 0, 'L', true);
            $Obj->Cell(45, 10, $Pre, 'B', 0, 'L', true);
            $Obj->Cell(70, 10, $Can, 'B', 0, 'L', true);
            $Obj->Cell(45, 10, $Enc, 'B', 0, 'L', true);
            $Obj->Ln();

            $Acu = $Pre * $Can;
            $AcuSubTot += $Acu;
            $tituloAnterior = $NomCli;
        }
        $anterior += $AcuSubTot;
        $total = $anterior;
        $Obj->Ln();
        $Obj->SetFont('Arial', 'B', 18);
        $Obj->SetTextColor(0, 0, 0);
        $Obj->SetFillColor(44, 255, 245);
        $Obj->Cell(340, 20, "Sub Total Comision Bs.: " . number_format($AcuSubTot), 'B', 5, 'C', true);


        $Obj->Ln();
        $Obj->Ln();
        $Obj->Ln();
        $Obj->Ln();
        $Obj->Cell(340, 20, "Total Cobrado Bs.: " . number_format($total), 'B', 5, 'C', true);

        $Obj->Output();
    }
    //Reporte adicional
    public function MostrarInformacion4($Fec1, $Fec2)
    {
        $Conexion = $this->Conectando() or die("Problema de conexion");
        $sql = "SELECT month(fechaventa)as MesVenta, COUNT(*) as cantidadVentaMes,
        SUM(precioventa) as SumaTotal, AVG(precioventa) as Promedio 
        FROM venta Where fechaventa BETWEEN  '$Fec1' AND '$Fec2'
        GROUP BY month(fechaventa)
        ORDER BY fechaventa ASC";
        $Tabla = mysqli_query($Conexion, $sql) or die("Problema de Ejecucion Informacion 1");
        mysqli_close($Conexion);
        $this->Reporte1V4($Tabla, $Fec1, $Fec2);
    }
    public function Reporte1V4($Tabla, $Fec1, $Fec2)
    {
        Header("Content-type: image/png");
        $ima = imagecreate(1920, 900); //Tamaño de la imagen.
        $fondo = imagecolorallocate($ima, 255, 255, 255); //Color R, G, B.

        $mesActual = "Enero";
        $Ancho = 100;
        $Separacion = 30;
        Imagefill($ima, 0, 0, $fondo);
        $Color = imagecolorallocate($ima, 53, 25, 52);
        $Tit1 = "Total Vendido por Mes";
        imagestring($ima, 5, 820, 10, $Tit1, $Color);
        //Muestra un texto horizontal: En que imagen, tamaño letra, coordenada x, coordenada Y, Texto, Color.
        $Tit2 = "Rango de Fechas. Desde: " . $Fec1 . " Hasta: " . $Fec2;
        imagestring($ima, 5, 720, 30, $Tit2, $Color);
        $EjeX = 800;
        $EjeY = 100;
        $AnchoEjeY = 1800;
        $IniMes = $EjeY + $Separacion;
        //Eje X barras
        imageline($ima, $EjeY - 10, $EjeX, $EjeY + $AnchoEjeY, $EjeX, $Color);
        //Eje Y barras
        imageline($ima, $EjeY, $EjeY, $EjeY, $EjeX + 5, $Color);
        //Testos barras
        $SeparacionTextoMes = 0;
        $SeparacionCuadros = 0;
        $SeparacionTextoTotal = 0;
        $Sumando = 0;
        while ($reg = mysqli_fetch_array($Tabla)) {     
            $MesVenta = $reg['MesVenta'];
            $fondoMes = imagecolorallocate($ima, rand(0, 255), rand(0, 255), rand(0, 255));
            $mesActual = $this->queMesSoy($MesVenta);
            $cantidadVentaMes = $reg['cantidadVentaMes'];
            $modificandoCantidad = $this->ModificarValor($cantidadVentaMes);
            $SumaTotal = $reg['SumaTotal'];
            $Sumando  += $SumaTotal;
            imagestring($ima, 4, $IniMes + 30 + $SeparacionTextoMes, $EjeX + 20, $mesActual, $Color);
            imagefilledrectangle($ima, $IniMes + $SeparacionCuadros, $EjeX - $modificandoCantidad - 10, $IniMes + $Ancho + $SeparacionCuadros, $EjeX - 10, $fondoMes);
            //Colocando etiquetas sobre las barras.
            imagestring($ima, 5, $IniMes + ($Ancho + $SeparacionTextoTotal) / 2 - 50, $EjeX - $modificandoCantidad - 10 - 40, "Ventas " . $cantidadVentaMes, $Color);
            imagestring($ima, 5, $IniMes + ($Ancho + $SeparacionTextoTotal) / 2 - 50, $EjeX - $modificandoCantidad - 10 - 20, "Monto " . $SumaTotal . " bs", $Color);
            $SeparacionCuadros += 150;
            $SeparacionTextoMes += 150;
            $SeparacionTextoTotal += 300;
        }
        imagestringup($ima, 5, $EjeY - 40, $EjeX - 100, "Total: " .$Sumando." Bs", $Color);

        Imagepng($ima);
        Imagedestroy($ima);
    }
    public function queMesSoy($mes)
    {
        if ($mes == 1) {
            return $actual = "Enero";
        }
        if ($mes == 2) {
            return $actual = "Febrero";
        }
        if ($mes == 3) {
            return $actual = "Marzo";
        }
        if ($mes == 4) {
            return $actual = "Abril";
        }
        if ($mes == 5) {
            return $actual = "Mayo";
        }

        if ($mes == 6) {
            return $actual = "Junio";
        }
        if ($mes == 7) {
            return $actual = "Julio";
        }
        if ($mes == 8) {
            return $actual = "Agosto";
        }
        if ($mes == 9) {
            return $actual = "Septiembre";
        }

        if ($mes == 10) {
            return $actual = "Octubre";
        }

        if ($mes == 11) {
            return $actual = "Noviembre";
        }
        if ($mes == 12) {
            return $actual = "Diciembre";
        }
    }
    public function ModificarValor($cantidadVentaMes)
    {
        if ($cantidadVentaMes < 100) {
            $cantidadVentaMes = $cantidadVentaMes * 10;
        }
        return $cantidadVentaMes;
    }
}

?>