<?php
    include('../../dbconnection.php');

    $fecha_gen = $_POST['fecha_gen'];
    $id_usuario = $_POST['id_usuario'];
    $id_medico = $_POST['id_medico'];
    $valor_total = $_POST['valor_total'];


   $query = "INSERT into pago(fecha_gen, valor_total, id_usuario, id_medico) 
            VALUES ('$fecha_gen','$valor_total','$id_usuario','$id_medico')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Pago registrado exitosamente";  


?>
