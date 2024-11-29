<?php

include_once '../../dbconnection.php';

  
  $id_disponibilidad = $_POST['id_disponibilidad'];
   $query = "SELECT * 
            FROM rango as ra
            WHERE  ra.id_disponibilidad = '{$id_disponibilidad}' ORDER BY ra.hora_ini ASC";
    
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'hora_ini' => $row['hora_ini'],
      'hora_fin' => $row['hora_fin']
    );
  }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
