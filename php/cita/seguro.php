<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

    $id_f_pago = $_POST['id_f_pago'];
    
    
    $query = "SELECT *
                FROM f_pago 
                WHERE id = '{$id_f_pago}'";

    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'aseguradora' => $row['aseguradora']          
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
    
?>
