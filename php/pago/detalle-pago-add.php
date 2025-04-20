<?php

include_once '../../dbconnection.php';
    $id_pago = $_POST['id_pago'];
    $id_cita = $_POST['id_cita'];

   $query = "INSERT into detalle_pago(id_pago,id_cita) 
            VALUES ('$id_pago','$id_cita')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Detalle de pago registrado exitosamente";  


?>
