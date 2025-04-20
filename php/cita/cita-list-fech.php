<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

    $fecha = $_POST['fecha'];
    $query = "SELECT ci.*, ase.nombre as seguro,  ca.id_medico, ca.id_paciente,me.sufijo, me.nombres_medi, me.apellidos_medi, pa.nombres_paci1, pa.apellidos_paci1, pa.nombres_paci2, pa.apellidos_paci2
                FROM cita AS ci
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                INNER JOIN medico AS me
                    ON me.id_medico = ca.id_medico
                INNER JOIN paciente AS pa
                    ON pa.id_paciente = ca.id_paciente
                INNER JOIN aseguradora AS ase
                    ON ase.id=ci.id_seguro
                WHERE ci.fecha = '{$fecha}' and (ci.id = '{$cita_agendada}' or ci.id = '{$cita_reagendada}')  ORDER BY me.nombres_medi DESC, ci.hora ASC";

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
          'id_caso' => $row['id_caso'],
          'id_medico' => $row['id_medico'],
          'id_paciente' => $row['id_paciente'],
          'sufijo' => $row['sufijo'],
          'nombres_medi' => $row['nombres_medi'],
          'apellidos_medi' => $row['apellidos_medi'],
          'nombres_paci1' => $row['nombres_paci1'],
          'apellidos_paci1' => $row['apellidos_paci1'],
          'nombres_paci2' => $row['nombres_paci2'],
          'apellidos_paci2' => $row['apellidos_paci2'],
          'seguro' => $row['seguro']
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }
?>
