<?php

include_once '../../dbconnection.php';

    $descripcion = $_POST['descripcion'];
    $pre_def = $_POST['pre_def'];
    $id_cie = $_POST['id_cie'];
    $diagnostico_esp = $_POST['diagnostico_esp'];
    $id_cita = $_POST['id_cita'];

    $query = "DELETE FROM diagnostico WHERE pre_def = '$pre_def' AND id_cie = '$id_cie' AND id_cita = '$id_cita'";
    $result = mysqli_query($conn, $query);

    $query = "INSERT into diagnostico(descripcion,pre_def,id_cie,id_cita, diagnostico_esp) 
            VALUES ('$descripcion','$pre_def','$id_cie','$id_cita','$diagnostico_esp')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Diagnóstico registrado exitósamente";  


?>
