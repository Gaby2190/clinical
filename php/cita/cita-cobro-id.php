<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';
   $id_cita = $_POST['id_cita'];
   $query = "SELECT ci.*, ca.id_medico, ca.id_paciente, me.pago_ingreso, me.sufijo, me.nombres_medi, me.apellidos_medi, pa.nombres_paci1, pa.apellidos_paci1, pa.nombres_paci2, pa.apellidos_paci2, me.tarifa, me.tarifa_control, usu.id_usuario, fp.aseguradora, fp.nombre 
                FROM cita AS ci 
                INNER JOIN caso AS ca ON ci.id_caso = ca.id_caso 
                INNER JOIN medico AS me ON me.id_medico = ca.id_medico 
                INNER JOIN paciente AS pa ON pa.id_paciente = ca.id_paciente 
                INNER JOIN usuario as usu ON pa.id_usuario = usu.id_usuario 
                INNER JOIN cita_pago as cip ON ci.id_cita = cip.id_cita 
                INNER JOIN f_pago as fp ON fp.id = cip.id_f_pago 
                WHERE ci.id_cita = '{$id_cita}' ORDER BY ci.id_cita ASC LIMIT 1";
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
          'nombres_paci1' => trim($row['nombres_paci1']),
          'apellidos_paci1' => trim($row['apellidos_paci1']),
          'nombres_paci2' => trim($row['nombres_paci2']),
          'apellidos_paci2' => trim($row['apellidos_paci2']),
          'actualizacion' => $row['actualizacion'],
          'id_usuario' => $row['id_usuario'],
          'aseguradora' => $row['aseguradora'],
          'fp_nombre' => $row['nombre']
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }
    
?>
