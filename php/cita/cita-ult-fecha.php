<?php

include('../../dbconnection.php');
include_once('../../variables.php');

    $id_caso = $_POST['id_caso'];
    $query = "SELECT * FROM cita WHERE id_caso = '{$id_caso}' and id = '{$cita_cobrada}' ORDER BY fecha DESC";
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
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
    }
?>
