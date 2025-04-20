<?php
include_once '../dbconnection.php';
include_once '../variables.php';
  $id_paciente = $_POST['id_paciente'];
  //$fecha = $_POST['fecha'];

  $query = "SELECT ci.id_cita 
            from cita as ci
            inner join caso as ca
              on ci.id_caso = ca.id_caso
            where ci.actualizacion = '$datos_no_actualizados' and ca.id_paciente = '{$id_paciente}'";
  
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_cita' => $row['id_cita']
        );
        
    }

    if (empty($json)) {
      echo false;
    }else{
      $jsonstring = json_encode($json);
      echo $jsonstring;
    }
   
?>
