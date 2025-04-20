<?php

include_once '../../dbconnection.php';

  $id_medico = $_POST['id_medico'];
  $fecha_cita = $_POST['fecha_cita'];
  $query = "SELECT dis.* 
            FROM disponibilidad as dis
            WHERE dis.id_medico = '{$id_medico}' AND dis.fecha = '{$fecha_cita}'
            GROUP BY dis.fecha  ORDER BY dis.fecha ASC";
    
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id_disponibilidad' => $row['id_disponibilidad'],
      'fecha' => $row['fecha']
    );
  }
  
  if (empty($json)) {
    echo false;
  }else{
  $jsonstring = json_encode($json);
  echo $jsonstring;
  }
?>
