<?php
include_once '../../dbconnection.php';
include_once '../../variables.php';

    $id_cita= $_POST['id_cita'];

    $query = "SELECT costo FROM cita_pago WHERE id_cita = '$id_cita' AND id_f_pago = '$transferencia_b'";
    
    $result = mysqli_query($conn, $query);

    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();

    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'costo' => $row['costo']
        );
    }
  
    if (empty($json)) {
        echo false;
    } else {
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
?>