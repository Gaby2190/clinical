<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

   $fecha = $_POST['fecha'];
   $id_usuario = $_POST['id_usuario'];
   $id_fpago = $_POST['id_fpago'];
   $query = "SELECT SUM(ci_pa.costo) as total, fp.nombre
                    FROM cita_pago AS ci_pa 
                    INNER JOIN cita AS ci ON ci_pa.id_cita = ci.id_cita 
                    INNER JOIN caso AS ca ON ci.id_caso = ca.id_caso 
                    INNER JOIN medico AS me ON me.id_medico = ca.id_medico 
                    INNER JOIN paciente AS pa ON pa.id_paciente = ca.id_paciente 
                    INNER JOIN usuario as usu ON pa.id_usuario = usu.id_usuario
                    INNER JOIN f_pago AS fp ON fp.id = ci_pa.id_f_pago
                WHERE ci_pa.fecha_p = '{$fecha}' and ci_pa.id_usuario = '{$id_usuario}' and fp.id='{$id_fpago}' GROUP BY fp.nombre ASC";
    $result = mysqli_query($conn, $query);
 
  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  } 

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'total' => $row['total'],
          'nombre' => $row['nombre']
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }
    
?>