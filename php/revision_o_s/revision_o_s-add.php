<?php

include_once '../../dbconnection.php';

    $orga_sist = $_POST['orga_sist'];
    $cp = $_POST['cp'];
    $descripcion = mb_strtoupper($_POST['descripcion']);
    $id_cita = $_POST['id_cita'];
    
    $query = "DELETE FROM revision_o_s WHERE orga_sist = '$orga_sist' AND id_cita='$id_cita';";
    $result = mysqli_query($conn, $query);


    $query = "INSERT into revision_o_s(orga_sist,cp,descripcion,id_cita) 
            VALUES ('$orga_sist','$cp','$descripcion','$id_cita');";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Revisión de órganos y sistemas registrados exitósamente";  


?>
