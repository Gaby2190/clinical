<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

    $id_cita = $_POST['id_cita'];
    $query = "SELECT ci.*, ca.id_medico, ca.motivo_con, ca.problema_act, me.tarifa, me.tarifa_control, me.sufijo, me.nombres_medi, me.apellidos_medi
                FROM cita AS ci
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                INNER JOIN medico AS me
                    ON ca.id_medico = me.id_medico
                WHERE ci.id_cita = '{$id_cita}'";

    $result = mysqli_query($conn, $query);//ejecuta la consulta Sql

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
          'tipo_cita' => $row['tipo_cita'],
          'id' => $row['id'],
          'id_caso' => $row['id_caso'],
          'motivo_con' => $row['motivo_con'],
          'problema_act' => $row['problema_act'],
          'id_medico' => $row['id_medico'],
          'sufijo' => $row['sufijo'],
          'nombres_medi' => $row['nombres_medi'],
          'apellidos_medi' => $row['apellidos_medi'],
          'tarifa' => $row['tarifa'],
          'tarifa_control' => $row['tarifa_control']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>
