<?php

include_once '../../dbconnection.php';

  $query = "SELECT * FROM tipo_pago";
    
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id_tipo_pago' => $row['id_tipo_pago'],
      'descripcion' => $row['descripcion']
      
    );
  }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
