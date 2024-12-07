<?php

include_once '../../dbconnection.php';

    $id_f_pago = $_POST['id_f_pago'];
    $descripcion = mb_strtoupper($_POST['descripcion']);
    $costo = $_POST['costo'];
    $id_cita = $_POST['id_cita'];
    $fecha_p = $_POST['fecha_p'];
    $hora_p = $_POST['hora_p'];
    $id_usuario = $_POST['id_usuario'];
    $id_t_pago = $_POST['id_t_pago'];
    $t_pago = $_POST['t_pago'];
    

    echo $query = "INSERT into cita_pago(descripcion,costo,id_cita,id_f_pago,fecha_p,hora_p,id_usuario, id_tipo_pago) 
            VALUES ('$descripcion','$costo','$id_cita','$id_f_pago','$fecha_p','$hora_p','$id_usuario','$id_t_pago')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Forma de pago registrada exitosamente";  


?>