<?php

include_once '../../dbconnection.php';

    $id_cita_pago = $_POST['id_cita_pago'];


    $query = "DELETE FROM cita_pago WHERE id_cita_pago = '{$id_cita_pago}'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Cita pago eliminada exitósamente";  


?>
