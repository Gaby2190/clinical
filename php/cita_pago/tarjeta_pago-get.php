<?php

    include('../../dbconnection.php');
    include('../../variables.php');

    $id_cita= $_POST['id_cita'];

    $query = "SELECT cp.*, fp.nombre 
                FROM cita_pago as cp
                INNER JOIN f_pago as fp
                    ON cp.id_f_pago = fp.id
                WHERE cp.id_cita = '{$id_cita}' and (cp.id_f_pago = '{$tarjeta_credito}' or cp.id_f_pago = '{$tarjeta_debito}')";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_cita_pago' => $row['id_cita_pago']
        );
    }
  
    if (empty($json)) {
        echo "false";
    }else{
        echo "true";
    }

?>
