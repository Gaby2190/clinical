<?php

include('../../dbconnection.php');
include('../../variables.php');
 
  $query = "SELECT ca.*, me.sufijo, me.nombres_medi, me.apellidos_medi, pa.apellidos_paci1, pa.apellidos_paci2, pa.nombres_paci1, pa.nombres_paci2, esp.nombre 
            FROM caso as ca
            INNER JOIN medico as me
              ON ca.id_medico = me.id_medico
            INNER JOIN paciente as pa
              ON ca.id_paciente = pa.id_paciente
            INNER JOIN especialidad as esp
              ON ca.id_especialidad = esp.id
            where ca.id = '{$caso_abierto}' ORDER BY fecha_registro DESC";
  //echo ($query);
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id_caso' => $row['id_caso'],
          'fecha_registro' => $row['fecha_registro'],
          'id_medico' => $row['id_medico'],
          'sufijo' => $row['sufijo'],
          'nombres_medi' => $row['nombres_medi'],
          'apellidos_medi' => $row['apellidos_medi'],
          'id_paciente' => $row['id_paciente'],
          'nombres_paci1' => $row['nombres_paci1'],
          'nombres_paci2' => $row['nombres_paci2'],
          'apellidos_paci1' => $row['apellidos_paci1'],
          'apellidos_paci2' => $row['apellidos_paci2'],
          'id' => $row['id'],
          'nombre' => $row['nombre']
        );
        
    }

    if (empty($json)) {
      echo false;
    }else{
      $jsonstring = json_encode($json);
      echo $jsonstring;
    }

?>
