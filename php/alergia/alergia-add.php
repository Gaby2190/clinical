<?php

include_once '../../dbconnection.php';


    $fecha = mysqli_real_escape_string($conn,$_POST['fecha']);
    $descripcion = mb_strtoupper(mysqli_real_escape_string($conn,$_POST['descripcion']));
    $id_medico = mysqli_real_escape_string($conn,$_POST['id_medico']);
    $id_paciente = mysqli_real_escape_string($conn,$_POST['id_paciente']);
    


   $query = "INSERT into alergia(fecha,descripcion,id_medico,id_paciente) 
            VALUES ('$fecha','$descripcion','$id_medico','$id_paciente')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Alergia registrada exitósamente";  


?>
