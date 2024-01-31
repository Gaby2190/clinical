<?php
include('../../../dbconnection.php');
include('../../../variables.php');


 $query = "SELECT ci.* 
            FROM cita as ci
            INNER JOIN caso as ca
                ON ci.id_caso = ca.id_caso
            WHERE (ci.id = '{$cita_cobrada}')";
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