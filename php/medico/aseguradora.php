<?php

include_once '../../dbconnection.php';

if(isset($_POST['id_medico'])) {

  $id_medico  = mysqli_real_escape_string($conn, $_POST['id_medico']);

  $query = "SELECT a.*, ase.nombre 
            FROM asegu_med as a
            INNER JOIN aseguradora as ase
              ON ase.id = a.id_seguro
            WHERE  a.id_medico = '{$id_medico}'";

  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'aseguradora' => $row['nombre'],
      'id_seguro' => $row['id'],
      'valor' => $row['valor']
    );
  }
  
    $jsonstring = json_encode($json);
  echo $jsonstring;
}

?>
 