<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

    $id_caso = $_POST['id_caso'];
    $query = "SELECT ci.*
                FROM cita AS ci
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                WHERE ci.id_caso = '{$id_caso}' ORDER BY ci.fecha DESC";

    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id_cita' => $row['id_cita'],
          'fecha' => $row['fecha']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>
