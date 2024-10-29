<?php

include_once '../../dbconnection.php';

    $id = $_POST['id'];
    $nombre = mb_strtoupper($_POST['nombre']);
    $aseguradora = $_POST['aseguradora'];

    $query = "UPDATE f_pago SET nombre = '$nombre', aseguradora = '$aseguradora' WHERE id = '$id'";
    
    $result = mysqli_query($conn, $query);

    if (!$result) {
    die('Actualización Fallida');
    }
    echo "Modificación exitosa de la forma de pago"; 


?>
