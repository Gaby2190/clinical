<?php

include_once '../../dbconnection.php';

if(isset($_POST['id_usuario'])) {

  $id = mysqli_real_escape_string($conn, $_POST['id_usuario']);

  $query = "SELECT * FROM asistente WHERE id_usuario = {$id}";
  
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '. mysqli_error($conn));
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
      'imagen' => $row['imagen']
    );
  }
  
    $jsonstring = json_encode($json[0]);
  echo $jsonstring;
}

?>
