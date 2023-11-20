<?php

    include('../../dbconnection.php');

    $query = "SELECT * FROM administrador ORDER BY nombres_admin ASC";
    
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id_administrador' => $row['id_administrador'],
      'cedula_admin' => $row['cedula_admin'],
      'nombres_admin' => $row['nombres_admin'],
      'apellidos_admin' => $row['apellidos_admin'],
      'telefono_admin' => $row['telefono_admin'],
      'celular_admin' => $row['celular_admin'],
      'correo_admin' => $row['correo_admin'],
      'direccion_admin' => $row['direccion_admin'],
      'imagen' => $row['imagen'],
      'id_usuario' => $row['id_usuario']
    );
  }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
