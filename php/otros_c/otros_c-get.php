<?php

include_once '../../dbconnection.php';

    $id_cita= $_POST['id_cita'];

    $query = "SELECT * FROM otro_c WHERE id_cita = '{$id_cita}'";
    
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
  
    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }

?>
