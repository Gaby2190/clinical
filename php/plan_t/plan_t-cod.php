<?php

include_once '../../dbconnection.php';

    $id_cita = $_POST['id_cita'];
    $id_medico = $_POST['id_medico'];
    //CONSULTA PARA OBTENER EL VALOR MÁXIMO DEL SECUENCIAL
    $query1 = "SELECT MAX(secuencial) AS max_secuencial
               FROM receta WHERE id_medico = '{$id_medico}'";
    
    $result1 = mysqli_query($conn, $query1);
    if(!$result1) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $sec = 1;
    while($row = mysqli_fetch_array($result1)) {
        $sec = intval($row['max_secuencial']);
    }

    if (isset($sec)) {
        $sec = $sec + 1;
    }else{
        $sec = 1;
    }

    //INSERCIÓN DEL ÚLTIMO VALOR EN LA TABLA DEL SECUENCIAL
    $query2 = "INSERT INTO receta(secuencial,id_medico,id_cita) 
            VALUES ('$sec','$id_medico','$id_cita')";
    $result2 = mysqli_query($conn, $query2);

    if (!$result2) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Secuencial Añadido con éxito";  


?>
