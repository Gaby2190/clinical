<?php

    include('../../dbconnection.php');
    $id_f_pago= mb_strtoupper($_POST['id_f_pago']);
    $descripcion= mb_strtoupper($_POST['descripcion']);
    $costo= $_POST['costo'];

    $query = "SELECT * FROM cita_pago WHERE id_f_pago = '{$id_f_pago}' AND descripcion = '{$descripcion}' AND costo = '{$costo}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_cita_pago' => $row['id_cita_pago'],
        'descripcion' => $row['descripcion'],
        'costo' => $row['costo']
        );
    }
  
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>
