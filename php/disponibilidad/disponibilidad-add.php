<?php

include_once '../../dbconnection.php';

    $id_medico = ($_POST['id_medico']);
    $fecha_cita = ($_POST['fecha_cita']);


    $query = "INSERT into disponibilidad(id_medico, fecha) 
            VALUES ('$id_medico','$fecha_cita')";
    $result = mysqli_query($conn, $query);
    $id=mysqli_insert_id($conn);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo $id;  


?>
