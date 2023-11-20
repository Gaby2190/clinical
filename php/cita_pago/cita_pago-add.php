<?php

    include('../../dbconnection.php');
    $id_f_pago = $_POST['id_f_pago'];
    $descripcion = mb_strtoupper($_POST['descripcion']);
    $costo = $_POST['costo'];
    $id_cita = $_POST['id_cita'];
    $fecha_p = $_POST['fecha_p'];
    $hora_p = $_POST['hora_p'];
    $id_usuario = $_POST['id_usuario'];


    $query = "INSERT into cita_pago(descripcion,costo,id_cita,id_f_pago,fecha_p,hora_p,id_usuario) 
            VALUES ('$descripcion','$costo','$id_cita','$id_f_pago','$fecha_p','$hora_p','$id_usuario')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Forma de pago registrada exit¨®samente";  


?>