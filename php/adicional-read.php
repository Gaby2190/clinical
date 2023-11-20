<?php

include('../dbconnection.php');

  $id_cita = $_POST['id_cita'];
 
  $query = "SELECT * from adicional where id_cita = '{$id_cita}'";
  
  $result = mysqli_query($conn, $query);
 
  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_adicional' => $row['id_adicional'],
        'descripcion' => $row['descripcion'],
        'costo' => $row['costo'],
        'id_cita' => $row['id_cita'],
        'id' => $row['id']
        );
        
    }

    if (empty($json)) {
      echo false;
    }else{
      $jsonstring = json_encode($json);
      echo $jsonstring;
    }
   
?>
