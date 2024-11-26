<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

    
    $query = "SELECT max(id_paciente) as maximo FROM paciente";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'maximo' => $row['maximo']
        );
        
    }

    if (empty($json)) {
      echo false;
  }else{
  $jsonstring = json_encode($json[0]);
  echo $jsonstring;
  }
?>
