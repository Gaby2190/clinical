<?php

include_once '../../dbconnection.php';

    $query = "SELECT me.* FROM `cita` as ci
INNER JOIN caso as ca
ON ci.id_caso = ca.id_caso
INNER JOIN medico as me
ON me.id_medico = ca.id_medico
WHERE me.estado_medi=1 AND ( ci.id=3 OR ci.id=6 OR ci.id=7)
GROUP BY me.cedula_medi;";
    
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id_medico' => $row['id_medico'],
      'cedula_medi' => $row['cedula_medi'],
      'sufijo' => $row['sufijo'],
      'nombres_medi' => $row['nombres_medi'],
      'apellidos_medi' => $row['apellidos_medi'],
      'telefono_medi' => $row['telefono_medi'],
      'celular_medi' => $row['celular_medi'],
      'correo_medi' => $row['correo_medi'],
      'direccion_medi' => $row['direccion_medi'],
      'nautorizacion_medi' => $row['nautorizacion_medi'],
      'estado_medi' => $row['estado_medi'],
      'imagen' => $row['imagen'],
      'tarifa' => $row['tarifa'],
      'tiempo_ap' => $row['tiempo_ap'],
      'id_usuario' => $row['id_usuario']
    );
  }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
