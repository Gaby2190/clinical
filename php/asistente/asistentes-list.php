<?php

include_once '../../dbconnection.php';

    $query = "SELECT * FROM asistente ORDER BY nombres_asis ASC";
    
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id_asistente' => $row['id_asistente'],
      'cedula_asis' => $row['cedula_asis'],
      'nombres_asis' => $row['nombres_asis'],
      'apellidos_asis' => $row['apellidos_asis'],
      'telefono_asis' => $row['telefono_asis'],
      'celular_asis' => $row['celular_asis'],
      'correo_asis' => $row['correo_asis'],
      'direccion_asis' => $row['direccion_asis'],
      'imagen' => $row['imagen'],
      'id_usuario' => $row['id_usuario']
    );
  }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
