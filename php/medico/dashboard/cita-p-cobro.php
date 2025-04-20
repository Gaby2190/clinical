<?php

include_once '../../../dbconnection.php';
include_once '../../../variables.php';

    $id_medico = $_POST['id_medico'];
    $query = "SELECT ci.*, ca.id_medico, ca.id_paciente,me.comision_c, me.pago_ingreso, me.comision_a, me.sufijo, me.nombres_medi, me.apellidos_medi, pa.nombres_paci1, pa.apellidos_paci1, pa.nombres_paci2, pa.apellidos_paci2, me.tarifa, me.tarifa_control
                FROM cita AS ci
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                INNER JOIN medico AS me
                    ON me.id_medico = ca.id_medico
                INNER JOIN paciente AS pa
                    ON pa.id_paciente = ca.id_paciente
                WHERE (ci.id = '{$cita_cobrada}' or ci.id = '{$cita_atendida}') AND ca.id_medico = '{$id_medico}' ORDER BY ci.id_cita ASC";
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
          'id' => $row['id'],
          'descuento' => $row['descuento'],
          'id_caso' => $row['id_caso'],
          'id_medico' => $row['id_medico'],
          'id_paciente' => $row['id_paciente'],
          'sufijo' => $row['sufijo'],
          'nombres_medi' => $row['nombres_medi'],
          'apellidos_medi' => $row['apellidos_medi'],
          'tarifa' => $row['tarifa'],
          'tarifa_control' => $row['tarifa_control'],
          'pago_ingreso' => $row['pago_ingreso'],
          'comision_c' => $row['comision_c'],
          'comision_a' => $row['comision_a'],
          'nombres_paci1' => $row['nombres_paci1'],
          'apellidos_paci1' => $row['apellidos_paci1'],
          'nombres_paci2' => $row['nombres_paci2'],
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
