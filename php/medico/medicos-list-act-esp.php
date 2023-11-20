<?php

    include('../../dbconnection.php');

    $id_especialidad = $_POST['id_esp'];
    $query = "SELECT me.*, es.*
              FROM medico AS me
              INNER JOIN info_academica AS ia
                ON ia.id_medico = me.id_medico
              INNER JOIN especialidad as es
                ON ia.id_espe = es.id
              WHERE me.estado_medi = 1 AND ia.id_espe = '{$id_especialidad}' order by apellidos_medi ASC";
    
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
