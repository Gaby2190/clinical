<?php

    include('../../dbconnection.php');

    $datos_m = mb_strtoupper($_POST['datos_m']);
    $via_a = $_POST['via_a'];
    $cantidad = $_POST['cantidad'];
    $indicaciones = mb_strtoupper($_POST['indicaciones']);
    $id_cita = $_POST['id_cita'];


   $query = "INSERT into plan_t(datos_m,via_a,cantidad,indicaciones,id_cita) 
            VALUES ('$datos_m','$via_a','$cantidad','$indicaciones','$id_cita')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Plan de tratamiento registrado exitósamente";  


?>
