<?php

include_once '../../dbconnection.php';


    $parentesco = mb_strtoupper(mysqli_real_escape_string($conn,$_POST['parentesco']));
    $descripcion = mb_strtoupper(mysqli_real_escape_string($conn,$_POST['descripcion']));
    $id_paciente = mysqli_real_escape_string($conn,$_POST['id_paciente']);
    $id_enfermedad = mysqli_real_escape_string($conn,$_POST['id_enfermedad']);


   $query = "INSERT into antecedente_f(parentesco,descripcion,id_paciente,id_enfermedad) 
            VALUES ('$parentesco','$descripcion','$id_paciente','$id_enfermedad')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Antecedente familiar registrado exitósamente";  


?>
