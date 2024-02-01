<?php
    include('../dbconnection.php');
   
    $universidad = mb_strtoupper($_POST['universidad']);
    $pais = mb_strtoupper($_POST['pais']);
    $id_medico = $_POST['id_medico'];
    $id_espe = $_POST['id_espe'];

    $query = "INSERT into info_academica(universidad, pais, id_medico, id_espe) VALUES ('$universidad', '$pais', '$id_medico','$id_espe')";
   
    
   
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Especialidad/es registrada/s con éxito";  
?>