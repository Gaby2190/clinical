<?php

    include('../../dbconnection.php');

    $id_enfermedad = $_POST['id_enfermedad'];
    $descripcion = mb_strtoupper($_POST['descripcion']);
    $fecha = $_POST['fecha'];
    $id_paciente = $_POST['id_paciente'];
    $id_medico = $_POST['id_medico'];


   $query = "INSERT into antecedente_p(id_enfermedad,descripcion,fecha,id_paciente,id_medico) 
            VALUES ('$id_enfermedad','$descripcion','$fecha','$id_paciente','$id_medico')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Antecedente personal registrado exitósamente";  


?>
