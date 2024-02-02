<?php

include_once '../../dbconnection.php';


    $comision_ban = $_POST['comision_ban'];
    $retencion_cli = $_POST['retencion_cli'];
    $id_cita = $_POST['id_cita'];


    $query = "INSERT into p_tarjeta(comision_ban,retencion_cli,id_cita) 
            VALUES ('$comision_ban','$retencion_cli','$id_cita')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Comisi��n del banco y retenci��n de la cl��nica registrados exitósamente";  


?>
