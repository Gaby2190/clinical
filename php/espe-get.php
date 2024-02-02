<?php

include_once '../dbconnection.php';


    $query = "SELECT * FROM especialidad";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id' => $row['id'],
        'nombre' => $row['nombre']
        );
    }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
