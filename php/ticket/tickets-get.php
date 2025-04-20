<?php

include_once '../../dbconnection.php';



    $query = "SELECT ci.id_cita, ci.fecha, ci.hora, 
              SUM(cp.costo) as costo, 
              me.sufijo, me.apellidos_medi, me.nombres_medi, 
              pa.nombres_paci1, pa.nombres_paci2, pa.apellidos_paci1, pa.apellidos_paci2 
              FROM cita as ci 
              INNER JOIN cita_pago as cp on cp.id_cita = ci.id_cita 
              INNER JOIN caso as ca ON ci.id_caso = ca.id_caso 
              INNER JOIN medico as me ON ca.id_medico = me.id_medico 
              INNER JOIN paciente as pa ON pa.id_paciente = ca.id_paciente 
              GROUP BY cp.id_cita ORDER BY ci.id_cita DESC";
    
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
        'costo' => $row['costo'],
        'sufijo' => $row['sufijo'],
        'apellidos_medi' => $row['apellidos_medi'],
        'nombres_medi' => $row['nombres_medi'],
        'nombres_paci1' => $row['nombres_paci1'],
        'nombres_paci2' => $row['nombres_paci2'],
        'apellidos_paci1' => $row['apellidos_paci1'],
        'apellidos_paci2' => $row['apellidos_paci2']

        );
    }
  
    if (empty($json)) {
        echo false;
      }else{
        $jsonstring = json_encode($json);
        echo $jsonstring;
      }
?>
