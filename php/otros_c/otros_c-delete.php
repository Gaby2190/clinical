<?php

    include('../../dbconnection.php');

    $id_otro_c = $_POST['id_otro_c'];


    $query = "DELETE FROM otro_c WHERE id_otro_c = '{$id_otro_c}'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Otro cobro eliminado exitósamente";  


?>
