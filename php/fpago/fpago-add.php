<?php

    include('../../dbconnection.php');

    $nombre = mb_strtoupper($_POST['fpago']);


    $query = "INSERT into f_pago(nombre) 
            VALUES ('$nombre')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Registro exitoso de la forma de pago";  


?>
