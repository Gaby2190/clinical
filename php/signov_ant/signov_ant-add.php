<?php

include_once '../../dbconnection.php';

    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $temperatura = $_POST['temperatura'];
    $presion_as = $_POST['presion_as'];
    $presion_ad = $_POST['presion_ad'];
    $pulso = $_POST['pulso'];
    $frecuencia_r = $_POST['frecuencia_r'];
    $frecuencia_c = $_POST['frecuencia_c'];
    $sat_o = $_POST['sat_o'];
    $peso = $_POST['peso'];
    $talla = $_POST['talla'];
    $perimetro = $_POST['perimetro'];
    $p_abdominal = $_POST['p_abdominal'];
    $hemo_cap = $_POST['hemo_cap'];
    $gluc_cap = $_POST['gluc_cap'];
    $pulsio = $_POST['pulsio'];
    $id_cita = $_POST['id_cita'];

    $query = "DELETE FROM signov_ant WHERE id_cita = '$id_cita' AND fecha = '$fecha' AND hora = '$hora' ;";
    $result = mysqli_query($conn, $query);

    $query = "INSERT into signov_ant(fecha,temperatura,presion_as,presion_ad,pulso,frecuencia_r,frecuencia_c,sat_o,peso,talla,perimetro_c,id_cita, hora, p_abdominal, h_capilar, g_capilar, pulsio) 
            VALUES ('$fecha','$temperatura','$presion_as','$presion_ad','$pulso','$frecuencia_r','$frecuencia_c','$sat_o','$peso','$talla','$perimetro','$id_cita','$hora','$p_abdominal','$hemo_cap','$gluc_cap','$pulsio')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Signo vital y antropometría registrado exitósamente";  


?>
