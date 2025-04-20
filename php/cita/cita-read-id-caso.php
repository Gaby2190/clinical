<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';
 
    $id_cita = $_POST['id_cita'];
    $query = "SELECT ci.*
                FROM cita AS ci
                WHERE ci.id_caso =   (SELECT id_caso FROM cita WHERE id_cita ='{$id_cita}' ) ";

    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id_cita' => $row['id_cita'],
          'motivo_con' => $row['motivo_con'],
          'fecha' => $row['fecha'],
          'problema_act' => $row['problema_act'],
          'evolucion' => $row['evolucion']
         
        );
        
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
