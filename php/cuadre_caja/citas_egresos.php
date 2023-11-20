<?php

include('../../dbconnection.php');

    $id_pago = $_POST['id_pago'];
                
    $query = "SELECT de_pa.*, ci.*, me.comision_c, me.comision_a, me.sufijo, me.nombres_medi, me.apellidos_medi, me.tarifa, me.tarifa_control
                FROM detalle_pago AS de_pa
                INNER JOIN cita AS ci
                    ON de_pa.id_cita = ci.id_cita
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                INNER JOIN medico AS me
                    ON me.id_medico = ca.id_medico
                WHERE de_pa.id_pago = '{$id_pago}' ORDER BY ci.id_cita ASC";


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
          'sufijo' => $row['sufijo'],
          'nombres_medi' => $row['nombres_medi'],
          'apellidos_medi' => $row['apellidos_medi'],
          'tarifa' => $row['tarifa'],
          'tarifa_control' => $row['tarifa_control'],
          'comision_c' => $row['comision_c'],
          'comision_a' => $row['comision_a']
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }
?>