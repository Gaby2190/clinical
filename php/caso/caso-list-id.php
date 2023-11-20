<?php

include('../../dbconnection.php');

    $id_caso = $_POST['id_caso'];
 
  $query = "SELECT * from caso where id_caso = '{$id_caso}'";
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id_caso' => $row['id_caso'],
          'descripcion' => $row['descripcion'],
          'fecha_registro' => $row['fecha_registro'],
          'id_medico' => $row['id_medico'],
          'id_paciente' => $row['id_paciente'],
          'id' => $row['id']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;

?>
