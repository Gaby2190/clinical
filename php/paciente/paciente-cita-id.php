<?php

include_once '../../dbconnection.php';

  $id_cita = $_POST['id_cita'];
  $query = "SELECT ci.id_cita, ca.id_caso, pa.id_paciente, pa.id_usuario
            FROM cita as ci
            INNER JOIN caso as ca
                ON ci.id_caso = ca.id_caso
            INNER JOIN paciente as pa
                ON ca.id_paciente = pa.id_paciente
            WHERE ci.id_cita = '$id_cita'";
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id_cita' => $row['id_cita'],
          'id_caso' => $row['id_caso'],
          'id_paciente' => $row['id_paciente'],
          'id_usuario' => $row['id_usuario']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;

?>
