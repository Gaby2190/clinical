<?php

include('../../dbconnection.php');

if(isset($_POST['id_usuario'])) {

  $id = mysqli_real_escape_string($conn, $_POST['id_usuario']);

  $query = "SELECT * FROM administrador WHERE id_usuario = {$id}";
  
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '. mysqli_error($conn));
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
      'imagen' => $row['imagen']
    );
  }
  
    $jsonstring = json_encode($json[0]);
   

  echo $jsonstring;
}

?>
