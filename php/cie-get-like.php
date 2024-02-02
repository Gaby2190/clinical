<?php

include_once '../dbconnection.php';

     $valor = strtr(trim($_POST['descripcion']), " ", "%");
    $query = "SELECT * FROM diagnosticoscie10 where descripcion like '%$valor%'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id' => $row['id'],
        'clave' => $row['clave'],
        'descripcion' => $row['descripcion']
        );
    }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
