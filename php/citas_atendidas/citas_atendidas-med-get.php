<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';
    
    
    $id_medico = $_POST['id_medico'];
    $fecha = $_POST['f_actual'];
                
    $query = "SELECT ci.id_cita,ci.fecha,ci.hora, me.sufijo, me.apellidos_medi, me.nombres_medi, pa.id_paciente, pa.nombres_paci1,pa.nombres_paci2,pa.apellidos_paci1,pa.apellidos_paci2
              FROM cita as ci
              INNER JOIN caso as ca
                ON ci.id_caso = ca.id_caso
              INNER JOIN medico as me
                ON ca.id_medico = me.id_medico
              INNER JOIN paciente as pa
                ON ca.id_paciente = pa.id_paciente
              WHERE (ci.id = '$cita_atendida' or ci.id = '$cita_cobrada' or ci.id = '$cita_finalizada') and ca.id_medico = '$id_medico' and ci.fecha = '$fecha' ORDER BY ci.hora DESC";
    
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_cita' => $row['id_cita'],
        'fecha' => $row['fecha'],
        'hora' => $row['hora'],
        'sufijo' => $row['sufijo'],
        'apellidos_medi' => $row['apellidos_medi'],
        'nombres_medi' => $row['nombres_medi'],
        'id_paciente' => $row['id_paciente'],
        'apellidos_paci1' => $row['apellidos_paci1'],
        'nombres_paci1' => $row['nombres_paci1'],
        'apellidos_paci2' => $row['apellidos_paci2'],
        'nombres_paci2' => $row['nombres_paci2']
        );
    }
  
    if (empty($json)) {
        echo false;
      }else{
        $jsonstring = json_encode($json);
        echo $jsonstring;
      }
?>