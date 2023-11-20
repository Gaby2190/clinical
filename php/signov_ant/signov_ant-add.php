<?php

    include('../../dbconnection.php');

    $fecha = $_POST['fecha'];
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
    $id_cita = $_POST['id_cita'];


   $query = "INSERT into signov_ant(fecha,temperatura,presion_as,presion_ad,pulso,frecuencia_r,frecuencia_c,sat_o,peso,talla,perimetro_c,id_cita) 
            VALUES ('$fecha','$temperatura','$presion_as','$presion_ad','$pulso','$frecuencia_r','$frecuencia_c','$sat_o','$peso','$talla','$perimetro','$id_cita')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Signo vital y antropometría registrado exitósamente";  


?>
