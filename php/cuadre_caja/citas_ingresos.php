<?php

include('../../dbconnection.php');
include_once('../../variables.php');

   $fecha = $_POST['fecha'];
   $id_usuario = $_POST['id_usuario'];
   $query = "SELECT ci_pa.fecha_p, ci_pa.hora_p, ci.*, ca.id_medico, ca.id_paciente, me.pago_ingreso, me.sufijo, me.nombres_medi, me.apellidos_medi, pa.nombres_paci1, pa.apellidos_paci1, pa.nombres_paci2, pa.apellidos_paci2, me.tarifa, me.tarifa_control, usu.id_usuario
                FROM cita_pago AS ci_pa
                INNER JOIN cita AS ci
                    ON ci_pa.id_cita = ci.id_cita
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                INNER JOIN medico AS me
                    ON me.id_medico = ca.id_medico
                INNER JOIN paciente AS pa
                    ON pa.id_paciente = ca.id_paciente
                INNER JOIN usuario as usu
                    ON pa.id_usuario = usu.id_usuario
                WHERE ci_pa.fecha_p = '{$fecha}' and ci_pa.id_usuario = '{$id_usuario}' GROUP BY ci_pa.id_cita ORDER BY ci_pa.id_cita ASC";
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
          'pago_ingreso' => $row['pago_ingreso'],
          'nombres_medi' => $row['nombres_medi'],
          'apellidos_medi' => $row['apellidos_medi'],
          'tarifa' => $row['tarifa'],
          'tarifa_control' => $row['tarifa_control'],
          'nombres_paci1' => $row['nombres_paci1'],
          'apellidos_paci1' => $row['apellidos_paci1'],
          'nombres_paci2' => $row['nombres_paci2'],
          'apellidos_paci2' => $row['apellidos_paci2'],
          'actualizacion' => $row['actualizacion'],
          'id_usuario' => $row['id_usuario'],
          'fecha_p' => $row['fecha_p'],
          'hora_p' => $row['hora_p']
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }
    
?>