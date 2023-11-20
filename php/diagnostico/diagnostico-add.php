<?php

    include('../../dbconnection.php');

    $descripcion = $_POST['descripcion'];
    $pre_def = $_POST['pre_def'];
    $id_cie = $_POST['id_cie'];
    $diagnostico_esp = $_POST['diagnostico_esp'];
    $id_cita = $_POST['id_cita'];


   $query = "INSERT into diagnostico(descripcion,pre_def,id_cie,id_cita, diagnostico_esp) 
            VALUES ('$descripcion','$pre_def','$id_cie','$id_cita','$diagnostico_esp')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Diagnóstico registrado exitósamente";  


?>
