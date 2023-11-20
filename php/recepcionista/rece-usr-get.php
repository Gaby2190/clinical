<?php

include('../../dbconnection.php');

  $query = "SELECT nombres_rece, apellidos_rece, id_usuario FROM recepcionista";
  
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id_usuario' => $row['id_usuario'],
      'nom_ape' => $row['nombres_rece']." ".$row['apellidos_rece']
    );
  }
  
  $jsonstring = json_encode($json);
  echo $jsonstring;

?>
