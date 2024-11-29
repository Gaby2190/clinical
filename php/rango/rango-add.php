<?php

include_once '../../dbconnection.php';

    $id_disponibilidad = ($_POST['id_disponibilidad']);
    $ini = ($_POST['ini']);
    $fin = ($_POST['fin']);


    $query = "INSERT into rango(id_disponibilidad , hora_ini, hora_fin) 
            VALUES ('$id_disponibilidad','$ini','$fin')";
    $result = mysqli_query($conn, $query);
   

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Rango Ingresado Exitosamente";  


?>
