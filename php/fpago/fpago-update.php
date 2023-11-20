<?php

    include('../../dbconnection.php');

    $id = $_POST['id'];
    $nombre = mb_strtoupper($_POST['nombre']);

    $query = "UPDATE f_pago SET nombre = '$nombre' WHERE id = '$id'";
    
    $result = mysqli_query($conn, $query);

    if (!$result) {
    die('Actualización Fallida');
    }
    echo "Forma de pago modificada satisfactoriamente"; 


?>
