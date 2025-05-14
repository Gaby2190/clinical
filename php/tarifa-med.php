<?php

include_once '../dbconnection.php';

if(isset($_POST['id_cita'])) {

  $id_cita = $_POST['id_cita'];
 
  $query = "SELECT ci.id_caso, ci.id_seguro , ci.tipo_cita, ca.id_medico, me.tarifa , me.tarifa_control, me.pago_ingreso
            FROM cita as ci
            INNER JOIN caso as ca
              ON ci.id_caso = ca.id_caso
            INNER JOIN medico as me
              ON ca.id_medico = me.id_medico
            WHERE  ci.id_cita = '{$id_cita}'";
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id_caso' => $row['id_caso'],
            'tipo_cita' => $row['tipo_cita'],
            'id_seguro' => $row['id_seguro'],
            'id_medico' => $row['id_medico'],
            'tarifa' => $row['tarifa'],
            'tarifa_control' => $row['tarifa_control'],
            'pago_ingreso' => $row['pago_ingreso']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

?>
