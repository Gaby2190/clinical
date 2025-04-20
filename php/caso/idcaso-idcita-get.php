<?php

include_once '../../dbconnection.php';

    $id_cita = $_POST['id_cita'];

    $query = "SELECT ci.id_caso
              FROM caso AS ca
              INNER JOIN cita AS ci
                  ON ci.id_caso = ca.id_caso
              WHERE ci.id_cita = '{$id_cita}'";
 
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id_caso' => $row['id_caso']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;

?>