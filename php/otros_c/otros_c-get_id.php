<?php

include_once '../../dbconnection.php';

    $descripcion= mb_strtoupper($_POST['descripcion']);
    $costo= $_POST['costo'];

    $query = "SELECT * FROM otro_c WHERE descripcion = '{$descripcion}' AND costo = '{$costo}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_otro_c' => $row['id_otro_c'],
        'descripcion' => $row['descripcion'],
        'costo' => $row['costo']
        );
    }
  
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>
