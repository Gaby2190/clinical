<?php
   include_once '../dbconnection.php';

    $id_cita = $_POST['id_cita'];

    $query = "DELETE FROM otro_c WHERE id_cita='$id_cita';";
    $result = mysqli_query($conn, $query);
   
    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Registros adicionales truncados con éxito";  
?>