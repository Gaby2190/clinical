<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

if(isset($_POST['fecha'])) {

  $fecha = $_POST['fecha'];
  $id_medico = $_POST['id_medico'];
 
  $query = "SELECT ci.*, ca.id_medico
            FROM cita AS ci
            INNER JOIN caso AS ca
                ON ci.id_caso = ca.id_caso
            WHERE ci.fecha = '{$fecha}' and ca.id_medico = '{$id_medico}' and (ci.id ='{$cita_agendada}' or ci.id ='{$cita_reagendada}')";
    
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
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }
}

?>
