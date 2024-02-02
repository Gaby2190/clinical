<?php

include_once '../../dbconnection.php';

if(isset($_POST['id_medico'])) {

  $id_medico  = mysqli_real_escape_string($conn, $_POST['id_medico']);

  $query = "SELECT ia.*, e.nombre 
            FROM info_academica as ia
            INNER JOIN especialidad as e
              ON ia.id_espe = e.id
            WHERE  ia.id_medico = '{$id_medico}'";

  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'nombre' => $row['nombre'],
      'universidad' => $row['universidad'],
      'pais' => $row['pais']
    );
  }
  
    $jsonstring = json_encode($json);
  echo $jsonstring;
}

?>
 