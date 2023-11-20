<?php

    include('../../dbconnection.php');

    $fecha = $_POST['fecha'];
    $descripcion = mb_strtoupper($_POST['descripcion']);
    $id_medico = $_POST['id_medico'];
    $id_paciente = $_POST['id_paciente'];
    


   $query = "INSERT into alergia(fecha,descripcion,id_medico,id_paciente) 
            VALUES ('$fecha','$descripcion','$id_medico','$id_paciente')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Alergia registrada exitósamente";  


?>
