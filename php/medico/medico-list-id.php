<?php

include_once '../../dbconnection.php';



if(isset($_POST['id_usuario'])) {

  $id = mysqli_real_escape_string($conn, $_POST['id_usuario']);

  $query = "SELECT * FROM medico WHERE id_usuario = {$id}";
  
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id_medico' => $row['id_medico'],
      'cedula_medi' => $row['cedula_medi'],
      'sufijo' => $row['sufijo'],
      'nombres_medi' => $row['nombres_medi'],
      'apellidos_medi' => $row['apellidos_medi'],
      'telefono_medi' => $row['telefono_medi'],
      'celular_medi' => $row['celular_medi'],
      'correo_medi' => $row['correo_medi'],
      'direccion_medi' => $row['direccion_medi'],
      'imagen' => $row['imagen']
    );
  }
  
    $jsonstring = json_encode($json[0]);
  echo $jsonstring;
}

?>
