<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $tipo_cita = $_POST['tipo_cita'];
    $id_caso = $_POST['id_caso'];
    $seguro = $_POST['seguro'];


    $query = "INSERT into cita(fecha,hora, tipo_cita, id, id_caso, id_seguro) 
            VALUES ('$fecha', '$hora', '$tipo_cita','$cita_agendada', '$id_caso','$seguro')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Cita registrada exitosamente";  


?>
