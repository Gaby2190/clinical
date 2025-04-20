<?php

include_once '../../dbconnection.php';

    $id_cita = $_POST['id_cita'];
    $query = "SELECT * FROM diagnostico where id_cita='$id_cita'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'descripcion' => $row['descripcion']
        );
    }
  
    if (empty($json)) {
        $json[] = array(
        'descripcion' => "Sin diagnóstico"
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }else{
      $jsonstring = json_encode($json[0]);
      echo $jsonstring;
    }
?>