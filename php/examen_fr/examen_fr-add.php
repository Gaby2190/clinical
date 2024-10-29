<?php

include_once '../../dbconnection.php';

    $examen_fr = $_POST['examen_fr'];
    $cp = $_POST['cp'];
    $descripcion = mb_strtoupper($_POST['descripcion']);
    $id_cita = $_POST['id_cita'];


    $query = "INSERT into examen_fr(examen_fr,cp,descripcion,id_cita) 
            VALUES ('$examen_fr','$cp','$descripcion','$id_cita')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Exámen físico regional registrado exitósamente";  


?>
