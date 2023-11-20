<?php

include('../../dbconnection.php');

    $fecha_registro = $_POST['fecha_registro'];
    $id_paciente = $_POST['id_paciente'];
    $id_medico = $_POST['id_medico'];
 
  $query = "SELECT * from caso where fecha_registro = '{$fecha_registro}' and id_medico = '{$id_medico}' and id_paciente = '{$id_paciente}' ORDER BY id_caso DESC";
  //echo ($query);
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
