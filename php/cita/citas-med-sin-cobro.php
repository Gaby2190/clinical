<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';


    $id_medico = $_POST['id_medico'];
    $query = "SELECT ci.fecha FROM cita AS ci 
    INNER JOIN caso AS ca ON ci.id_caso = ca.id_caso 
    INNER JOIN medico AS me ON me.id_medico = ca.id_medico 
    INNER JOIN paciente AS pa ON pa.id_paciente = ca.id_paciente 
    WHERE ca.id_medico ='{$id_medico}' and (ci.id = '{$cita_atendida}' or ci.id = '{$cita_cobrada}' or ci.id = '{$cita_espera}')  group by fecha;";

    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'fecha' => $row['fecha']
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }
?>
