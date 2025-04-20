<?php

include_once '../../dbconnection.php';

  $id_medico = $_POST['id_medico'];
  $query = "SELECT esp.* 
            FROM especialidad as esp
            INNER JOIN info_academica AS ia
              ON esp.id = ia.id_espe
            WHERE ia.id_medico = '{$id_medico}' ORDER BY esp.nombre ASC";
    
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
