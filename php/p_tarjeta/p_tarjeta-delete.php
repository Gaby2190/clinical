<?php

    include('../../dbconnection.php');

    $id_p_tarjeta = $_POST['id_p_tarjeta'];


    $query = "DELETE FROM p_tarjeta WHERE id_p_tarjeta = '{$id_p_tarjeta}'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Comisi¨®n banco y retenci¨®n cl¨ªnica eliminados exitÃ³samente";  


?>
