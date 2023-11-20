<?php

include('../../dbconnection.php');
include_once('../../variables.php');
 
    $id_cita = $_POST['id_cita'];
    $query = "SELECT ci.*, ca.id_medico, ca.semana_embarazo
                FROM cita AS ci
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                WHERE ci.id_cita = '{$id_cita}'";

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
          'tipo_cita' => $row['tipo_cita'],
          'dias_reposo' => $row['dias_reposo'],
          'descuento' => $row['descuento'],
          'signos_a' => $row['signos_a'],
          'recomendaciones_nf' => $row['recomendaciones_nf'],
          'detalle_certificado' => $row['detalle_certificado'],
          'id' => $row['id'],
          'id_caso' => $row['id_caso'],
          'id_medico' => $row['id_medico'],
          'semana_embarazo' => $row['semana_embarazo'],
          'actualizacion' => $row['actualizacion'],
          'evolucion' => $row['evolucion'],
          't_contingencia' => $row['t_contingencia']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>
