<?php
include('../../../dbconnection.php');
include('../../../variables.php');

  $id_medico = $_POST['id_medico'];
 
  $query = "SELECT * from caso where id_medico = '{$id_medico}' and id = '{$caso_abierto}'";
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id_caso' => $row['id_caso']
        );
        
    }

    if (empty($json)) {
      echo false;
    }else{
      $jsonstring = json_encode($json);
      echo $jsonstring;
    }
?>