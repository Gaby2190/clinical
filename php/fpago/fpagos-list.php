<?php

include_once '../../dbconnection.php';

  $query = "SELECT f.*, a.nombre as aseguradora
            FROM f_pago as f
             INNER JOIN aseguradora as a
                ON f.aseguradora = a.id
            ORDER BY f.id ASC";
    
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id' => $row['id'],
      'nombre' => $row['nombre'],
      'aseguradora' => $row['aseguradora']
    );
  }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
