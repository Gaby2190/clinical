<?php

include_once '../../dbconnection.php';

  $query = "SELECT nombres_caje, apellidos_caje, id_usuario FROM cajero";
  
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id_usuario' => $row['id_usuario'],
      'nom_ape' => $row['nombres_caje']." ".$row['apellidos_caje']
    );
  }
  
  $jsonstring = json_encode($json);
  echo $jsonstring;

?>
