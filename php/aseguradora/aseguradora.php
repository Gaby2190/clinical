<?php
include_once '../../dbconnection.php';
   
    $id_segu = $_POST['id_segu'];
    $valor = $_POST['valor'];
    $id_medico = $_POST['id_medico'];


    $query = "INSERT into asegu_med(id, id_seguro, valor, id_medico) VALUES (0, $id_segu, $valor,$id_medico)";
   
    
   
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Aseguradora/s registrada/s con éxito";  
?>