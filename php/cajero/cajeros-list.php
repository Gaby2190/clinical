<?php

include_once '../../dbconnection.php';

    $query = "SELECT * FROM cajero ORDER BY nombres_caje ASC";
    
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id_cajero' => $row['id_cajero'],
      'cedula_caje' => $row['cedula_caje'],
      'nombres_caje' => $row['nombres_caje'],
      'apellidos_caje' => $row['apellidos_caje'],
      'telefono_caje' => $row['telefono_caje'],
      'celular_caje' => $row['celular_caje'],
      'correo_caje' => $row['correo_caje'],
      'direccion_caje' => $row['direccion_caje'],
      'imagen' => $row['imagen'],
      'id_usuario' => $row['id_usuario']
    );
  }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
