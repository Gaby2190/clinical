<?php

include_once '../../dbconnection.php';

if(isset($_POST['id_usuario'])) {

  $id = mysqli_real_escape_string($conn, $_POST['id_usuario']);

  $query = "SELECT * FROM cajero WHERE id_usuario = {$id}";
  
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '. mysqli_error($conn));
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
      'imagen' => $row['imagen']
    );
  }
  
    $jsonstring = json_encode($json[0]);
  echo $jsonstring;
}

?>
