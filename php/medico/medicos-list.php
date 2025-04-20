<?php

include_once '../../dbconnection.php';

    $query = "SELECT * FROM medico ORDER BY apellidos_medi ASC";
    
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
      'tarifa_control' => $row['tarifa_control'],
      'pago_ingreso' => $row['pago_ingreso'],
      'comision_c' => $row['comision_c'],
      'comision_a' => $row['comision_a'],
      'tiempo_ap' => $row['tiempo_ap'],
      'id_usuario' => $row['id_usuario']
    );
  }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
