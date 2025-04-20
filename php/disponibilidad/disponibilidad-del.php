<?php

include_once '../../dbconnection.php';

    $id_disponibilidad = ($_POST['id_disponibilidad']);
  


    $query = "DELETE FROM rango WHERE id_disponibilidad = {$id_disponibilidad}";
    $result = mysqli_query($conn, $query);
    
    $query = "DELETE FROM disponibilidad WHERE id_disponibilidad = {$id_disponibilidad}";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo 'Disponibilidad eliminada exitosamente';  


?>
