<?php
include_once '../../../dbconnection.php';
include_once '../../../variables.php';

  $id_medico = $_POST['id_medico'];
 
  $query = "SELECT ci.* 
            FROM cita as ci
            INNER JOIN caso as ca
                ON ci.id_caso = ca.id_caso
            WHERE ca.id_medico = '{$id_medico}' AND ci.id = '{$cita_finalizada}'";
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id_cita' => $row['id_cita'],
            'fecha' => $row['fecha'],
            'hora' => $row['hora']
        );
        
    }

    if (empty($json)) {
      echo false;
    }else{
      $jsonstring = json_encode($json);
      echo $jsonstring;
    }
?>