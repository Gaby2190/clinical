<?php
include_once '../../dbconnection.php';
require __DIR__ . '/autoload.php';
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

    //Traer los datos de la base de datos
    $id_cita = $_POST['id_cita'];
    //$id_cita = "142";

    $query = "SELECT ci.*, ca.id_medico, me.sufijo, me.nombres_medi, me.apellidos_medi, me.pago_ingreso, me.tarifa, me.tarifa_control, pa.nombres_paci1, pa.nombres_paci2, pa.apellidos_paci1, pa.apellidos_paci2
                FROM cita AS ci
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                INNER JOIN medico as me
                    ON ca.id_medico = me.id_medico
                INNER JOIN paciente as pa
                    ON ca.id_paciente = pa.id_paciente
                WHERE ci.id_cita = '{$id_cita}'";

    
    $result = mysqli_query($conn, $query);

    if(!$result) {
        die('Error en consulta '.mysqli_error($conn));
    }

    while($row = mysqli_fetch_array($result)) {
        $id_cita  = $row['id_cita'];
        $descripcion = $row['descripcion'];
        $fecha = $row['fecha'];
        $hora = $row['hora'];
        $tipo_cita = $row['tipo_cita'];
        $id = $row['id'];
        $id_caso = $row['id_caso'];
        $id_medico = $row['id_medico'];
        $nombres_medi = $row['nombres_medi'];
        $apellidos_medi = $row['apellidos_medi'];
        $pago_ingreso = $row['pago_ingreso'];
        $tarifa = $row['tarifa'];
        $tarifa_control = $row['tarifa_control'];
        $nombres_paci1 = $row['nombres_paci1'];
        $apellidos_paci1 = $row['apellidos_paci1'];
        $nombres_paci2 = $row['nombres_paci2'];
        $apellidos_paci2 = $row['apellidos_paci2'];
        $sufijo = $row['sufijo'];
    }
    //Realizar la impresión del ticket
    $nombre_impresora = "I-T";
    $connector = new WindowsPrintConnector($nombre_impresora);
    $printer = new Printer($connector);
    $printer->setJustification(Printer::JUSTIFY_CENTER);

    // $logo = EscposImage::load('logo.jpg', false);
    // $printer->bitImage($logo);

    /*
    Imprimimos un mensaje. Podemos usar
    el salto de línea o llamar muchas
    veces a $printer->text()
    */
    $printer->setFont(Printer::FONT_C);
    $printer->setTextSize(1, 1);
    $printer->text("Centro de Especialidades Médicas\n");
    $printer->setTextSize(2, 1);
    $printer->text('"CESMED" S.C.'."\n");
    $printer->setTextSize(1, 1);
    $printer->text("Al cuidado de su salud y la de su familia\n\n");
    $printer->setTextSize(1, 2);
    $printer->text($sufijo." ".$apellidos_medi." ".$nombres_medi."\n\n");
    $printer->setTextSize(3, 3);
    $printer->text("Turno N° ".$id_cita."\n\n");
    $printer->setTextSize(2, 1);
    $printer->text("Fecha: ".$fecha."\n\n");
    $printer->text("Hora: ".substr($hora, 0, -3)."h \n\n");
    $printer->setTextSize(1, 2);

    $printer->text("Paciente: ".$apellidos_paci1." ".$apellidos_paci2." ".$nombres_paci1." ".$nombres_paci2."\n\n");
    //$printer->text("CITA N°: ".$id_cita."\n\n");
    $printer->setTextSize(2, 1);

    if ($tipo_cita == "1") {
        $printer->text("Tipo de cita: Normal\n\n");
        $printer->setTextSize(1, 1);

        if (intval($pago_ingreso) == 1) {
            $printer->text("Valor cancelado: ".$tarifa." usd.\n\n");
        }else{
            $printer->text("Valor cancelado: 0.00 usd.\n\n");
        }
    }
    if ($tipo_cita == "0") {
        $printer->text("Tipo de cita: Control\n\n");
        $printer->setTextSize(1, 1);
        if (intval($pago_ingreso) == 1) {
            $printer->text("Valor cancelado: ".$tarifa_control." usd.\n\n");
        }else{
            $printer->text("Valor cancelado: 0.00 usd.\n\n");
        }
    }

    $printer->setTextSize(2, 1);
    $printer->text("AGENDA TU PRÓXIMA CITA\n");
    $printer->text("0992552373 - 062985931\n");
    $printer->text("www.cesmed.ec\n\n");
    $printer->setTextSize(1, 2);
    $printer->text("¡Gracias por preferirnos!\n\n");

    /*
    Hacemos que el papel salga. Es como
    dejar muchos saltos de línea sin escribir nada
    */
    $printer->feed(1);

    /*
    Cortamos el papel. Si nuestra impresora
    no tiene soporte para ello, no generará
    ningún error
    */
    $printer->cut();

    /*
    Por medio de la impresora mandamos un pulso.
    Esto es útil cuando la tenemos conectada
    por ejemplo a un cajón
    */
    $printer->pulse();

    /*
    Para imprimir realmente, tenemos que "cerrar"
    la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
    */
    $printer->close();

?>
