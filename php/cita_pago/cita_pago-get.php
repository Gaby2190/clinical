<?php

include_once '../../dbconnection.php';

    $id_cita= $_POST['id_cita'];

    $query = "SELECT cp.*, fp.nombre, me.tarifa, me.tarifa_control, me.pago_ingreso, ci.tipo_cita, fp.aseguradora
                FROM cita_pago as cp
                INNER JOIN f_pago as fp
                    ON cp.id_f_pago = fp.id
                INNER JOIN cita as ci
                    ON cp.id_cita = ci.id_cita
                INNER JOIN caso as ca
                    ON ci.id_caso = ca.id_caso
                INNER JOIN medico as me
                    ON ca.id_medico = me.id_medico
                WHERE cp.id_cita = $id_cita";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_cita_pago' => $row['id_cita_pago'],
        'descripcion' => $row['descripcion'],
        'costo' => $row['costo'],
        'id_f_pago' => $row['id_f_pago'],
        'nombre' => $row['nombre'],
        'fecha_p' => $row['fecha_p'],
        'hora_p' => $row['hora_p'],
        'tarifa' => $row['tarifa'],
        'tarifa_control' => $row['tarifa_control'],
        'pago_ingreso' => $row['pago_ingreso'],
        'tipo_cita' => $row['tipo_cita'],
        'aseguradora' => $row['aseguradora']
        );
    }
  
    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }

?>
