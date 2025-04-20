<?php

include_once '../../dbconnection.php';

    $query = "SELECT * FROM recepcionista ORDER BY nombres_rece ASC";
    
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id_recepcionista' => $row['id_recepcionista'],
      'cedula_rece' => $row['cedula_rece'],
      'nombres_rece' => $row['nombres_rece'],
      'apellidos_rece' => $row['apellidos_rece'],
      'telefono_rece' => $row['telefono_rece'],
      'celular_rece' => $row['celular_rece'],
      'correo_rece' => $row['correo_rece'],
      'direccion_rece' => $row['direccion_rece'],
      'imagen' => $row['imagen'],
      'id_usuario' => $row['id_usuario']
    );
  }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
