<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

    $id_medico = $_POST['id_medico'];
    $fecha_cita = $_POST['fecha_cita'];

    $query = "SELECT * FROM `cita` as ci INNER JOIN caso as ca ON ci.id_caso=ca.id_caso WHERE ca.id_medico='{$id_medico}' AND ci.fecha='{$fecha_cita}' AND ci.id = '{$cita_agendada}';";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id_cita' => $row['id_cita'],
          'descripcion' => $row['descripcion'],
          'fecha' => $row['fecha'],
          'hora' => $row['hora'],
          'id' => $row['id'],
          'id_caso' => $row['id_caso']
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
        echo true;
    }
?>
