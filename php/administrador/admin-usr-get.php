<?php

include_once '../../dbconnection.php';
 

  $query = "SELECT nombres_admin, apellidos_admin, id_usuario FROM administrador";
  
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id_usuario' => $row['id_usuario'],
      'nom_ape' => $row['nombres_admin']." ".$row['apellidos_admin']
    );
  }
  
  $jsonstring = json_encode($json);
  echo $jsonstring;

?>
