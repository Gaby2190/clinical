<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

   $fecha = $_POST['fecha'];
   $id_usuario = $_POST['id_usuario'];
   $query = "SELECT * FROM f_pago ORDER BY aseguradora";
    $result = mysqli_query($conn, $query);
 
  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  } 

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id' => $row['id'],
          'nombre' => $row['nombre'],
          'aseguradora' => $row['aseguradora'],
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }
    
?>