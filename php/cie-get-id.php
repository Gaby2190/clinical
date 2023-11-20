<?php

    include('../dbconnection.php');

    $id = $_POST["id"];
    $query = "SELECT * FROM diagnosticoscie10 where id = '{$id}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'clave' => $row['clave'],
        'descripcion' => $row['descripcion']
        );
    }
  
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>
