<?php

include_once '../../dbconnection.php';

    $nombre = mb_strtoupper($_POST['especialidad']);


    $query = "INSERT into especialidad(nombre) 
            VALUES ('$nombre')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "La especialidad fue ingresada exitosamente ";  


?>
