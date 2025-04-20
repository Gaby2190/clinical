<?php

include_once '../../dbconnection.php';

    $fecha_gen = $_POST['fecha_gen'];
    $id_usuario = $_POST['id_usuario'];
    $id_medico = $_POST['id_medico'];
    $valor_total = $_POST['valor_total'];

    $query = "SELECT max(id_pago) as id_pago FROM pago WHERE fecha_gen = '{$fecha_gen}' and id_usuario = '{$id_usuario}' and id_medico = '{$id_medico}' and valor_total = '{$valor_total}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_pago' => $row['id_pago']
        );
    }
  
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>
