<?php

include_once '../../dbconnection.php';

    $id_cita= $_POST['id_cita'];

    $query = "SELECT * FROM p_tarjeta WHERE id_cita = '{$id_cita}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_p_tarjeta' => $row['id_p_tarjeta'],
        'comision_ban' => $row['comision_ban'],
        'retencion_cli' => $row['retencion_cli']
        );
    }
  
    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
        echo $jsonstring;
    }

?>
