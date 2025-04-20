<?php

include_once '../../dbconnection.php';

    $nombre = mb_strtoupper($_POST['aseguradora']);


    $query = "INSERT into aseguradora(nombre) 
            VALUES ('$nombre')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Registro exitoso de la Aseguradora";  


?>
