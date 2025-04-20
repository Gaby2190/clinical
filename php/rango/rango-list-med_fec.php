<?php

include_once '../../dbconnection.php';

  
 $fecha = $_POST['fecha'];
 $id_medico = $_POST['id_medico'];
   $query = "SELECT * 
            FROM rango as ra
            WHERE  ra.id_disponibilidad =  (SELECT id_disponibilidad FROM disponibilidad WHERE id_medico='".$id_medico."' AND fecha='".$fecha."') ORDER BY ra.hora_ini ASC";
    
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'hora_ini' => $row['hora_ini'],
      'hora_fin' => $row['hora_fin']
    );
  }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
