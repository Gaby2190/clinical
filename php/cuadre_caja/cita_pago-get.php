<?php

include_once '../../dbconnection.php';

    $id_cita= $_POST['id_cita'];
    $fecha_p= $_POST['fecha'];

    $query = "SELECT cp.*, fp.nombre 
                FROM cita_pago as cp
                INNER JOIN f_pago as fp
                    ON cp.id_f_pago = fp.id
                WHERE cp.id_cita = '{$id_cita}' and cp.fecha_p = '{$fecha_p}'";
    
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
