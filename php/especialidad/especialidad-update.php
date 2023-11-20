<?php

    include('../../dbconnection.php');

    $id = $_POST['id'];
    $nombre = mb_strtoupper($_POST['nombre']);

    $query = "UPDATE especialidad SET nombre = '$nombre' WHERE id = '$id'";
    
    $result = mysqli_query($conn, $query);

    if (!$result) {
    die('Actualización Fallida');
    }
    echo "Especialidad modificada satisfactoriamente"; 


?>
