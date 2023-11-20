<?php

    include('../../dbconnection.php');
    $id_f_pago = $_POST['id_f_pago'];
    $descripcion = mb_strtoupper($_POST['descripcion']);
    $costo = $_POST['costo'];
    $id_pago = $_POST['id_pago'];
    $fecha_p = $_POST['fecha_p'];
    $hora_p = $_POST['hora_p'];


    $query = "INSERT into medico_pago(descripcion,costo,id_pago,id_f_pago,fecha_p,hora_p) 
            VALUES ('$descripcion','$costo','$id_pago','$id_f_pago','$fecha_p','$hora_p')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Forma de pago registrada exitósamente";  


?>
