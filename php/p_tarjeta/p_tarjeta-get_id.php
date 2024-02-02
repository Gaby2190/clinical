<?php

include_once '../../dbconnection.php';

    $retencion_cli= $_POST['retencion_cli'];
    $comision_ban= $_POST['comision_ban'];

    $query = "SELECT * FROM p_tarjeta WHERE retencion_cli = '{$retencion_cli}' AND comision_ban = '{$comision_ban}'";
    
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
  
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>
