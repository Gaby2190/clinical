<?php

    include('../../dbconnection.php');

    $orga_sist = $_POST['orga_sist'];
    $cp = $_POST['cp'];
    $descripcion = mb_strtoupper($_POST['descripcion']);
    $id_cita = $_POST['id_cita'];


   $query = "INSERT into revision_o_s(orga_sist,cp,descripcion,id_cita) 
            VALUES ('$orga_sist','$cp','$descripcion','$id_cita')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Revisión de órganos y sistemas registrados exitósamente";  


?>
