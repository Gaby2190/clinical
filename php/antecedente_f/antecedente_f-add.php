<?php

    include('../../dbconnection.php');

    $parentesco = mb_strtoupper($_POST['parentesco']);
    $descripcion = mb_strtoupper($_POST['descripcion']);
    $id_paciente = $_POST['id_paciente'];
    $id_enfermedad = $_POST['id_enfermedad'];


   $query = "INSERT into antecedente_f(parentesco,descripcion,id_paciente,id_enfermedad) 
            VALUES ('$parentesco','$descripcion','$id_paciente','$id_enfermedad')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Antecedente familiar registrado exitósamente";  


?>
