<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

   $fecha = $_POST['fecha'];
   $id_usuario = $_POST['id_usuario'];
  
   
    $query = "SELECT ci.id_cita, 
	   cp.descripcion, cp.costo, cp.fecha_p, cp.hora_p,
       me.sufijo, me.nom_ape_medi, me.comision_c, me.comision_a,
       pa.nombres_paci1, pa.nombres_paci2, pa.apellidos_paci1, pa.apellidos_paci2,
       fp.id, fp.nombre as forma_pago,
       tp.id_tipo_pago, tp.descripcion as tipo_pago
        FROM cita_pago as cp
        INNER JOIN cita as ci
        ON cp.id_cita = ci.id_cita
        INNER JOIN caso as ca
        ON ca.id_caso = ci.id_caso
        INNER JOIN medico as me
        ON ca.id_medico = me.id_medico
        INNER JOIN paciente as pa
        ON pa.id_paciente = ca.id_paciente
        INNER JOIN f_pago as fp
        ON fp.id = cp.id_f_pago
        INNER JOIN tipo_pago as tp
        ON tp.id_tipo_pago = cp.id_tipo_pago
        WHERE cp.fecha_p = '{$fecha}'  ORDER BY cp.id_cita ASC";
   
   //and cp.id_usuario = '{$id_usuario}'
   
    $result = mysqli_query($conn, $query);
 
  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  } 

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id_cita' => $row['id_cita'],
          'descripcion' => $row['descripcion'],
          'costo' => $row['costo'],
          'fecha_p' => $row['fecha_p'],
          'hora_p' => $row['hora_p'],
          'sufijo' => $row['sufijo'],
          'nom_ape_medi' => $row['nom_ape_medi'],
          'comision_c' => $row['comision_c'],
          'comision_a' => $row['comision_a'],
          'nombres_paci1' => $row['nombres_paci1'],
          'nombres_paci2' => $row['nombres_paci2'],
          'apellidos_paci1' => $row['apellidos_paci1'],
          'apellidos_paci2' => $row['apellidos_paci2'],
          'nom_ape_medi' => $row['nom_ape_medi'],
          'id' => $row['id'],
          'forma_pago' => $row['forma_pago'],
          'id_tipo_pago' => $row['id_tipo_pago'],
          'tipo_pago' => $row['tipo_pago']
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }
    
?>