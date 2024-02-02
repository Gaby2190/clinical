<?php

include_once '../../dbconnection.php';
    include_once '../../variables.php';
    $id_medico = $_POST['id_medico'];
    $query = "SELECT pa.* 
    FROM paciente as pa
    INNER JOIN caso as ca
      ON pa.id_paciente = ca.id_paciente
    WHERE ca.id = '$caso_cerrado' and ca.id_medico = '{$id_medico}' GROUP BY pa.cedula_paci ORDER BY nombres_paci1 ASC";


    $result = mysqli_query($conn, $query);

    if(!$result) {
      die('Consulta fallida'. mysqli_error($conn));
    }
  
    $json = array();
    while($row = mysqli_fetch_array($result)) {
      $json[] = array(
        'id_paciente' => $row['id_paciente'],
        'cedula_paci' => $row['cedula_paci'],
        'nombres_paci1' => trim($row['nombres_paci1']),
        'apellidos_paci1' => trim($row['apellidos_paci1']),
        'nombres_paci2' => trim($row['nombres_paci2']),
        'apellidos_paci2' => trim($row['apellidos_paci2']),
        'celular_paci' => $row['celular_paci'],
        'imagen' => $row['imagen'],
        'id_usuario' => $row['id_usuario']
      );
    }
    
      $jsonstring = json_encode($json);
      echo $jsonstring;
?>
