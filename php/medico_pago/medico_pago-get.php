<?php

include_once '../../dbconnection.php';

    $id_pago= $_POST['id_pago'];

    $query = "SELECT mp.*, fp.nombre 
              FROM medico_pago as mp
              INNER JOIN f_pago as fp
                ON mp.id_f_pago = fp.id
              WHERE mp.id_pago = '{$id_pago}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_medico_pago' => $row['id_medico_pago'],
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