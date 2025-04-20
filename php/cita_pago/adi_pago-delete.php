<?php

include_once '../../dbconnection.php';

    $id_cita = $_POST['id_cita'];
    $descripcion = $_POST['descripcion'];
    $costo = $_POST['costo'];


    $query = "DELETE FROM adicional WHERE id_cita = '{$id_cita}' AND descripcion = '{$descripcion}' AND costo = '{$costo}'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Adicional eliminada exitósamente";  


?>
