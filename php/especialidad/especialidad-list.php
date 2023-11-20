<?php

include('../../dbconnection.php');

if(isset($_POST['id'])) {

  $id = $_POST['id'];
 
  $query = "SELECT * from especialidad where id = '{$id}'";
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id' => $row['id'],
            'nombre' => $row['nombre']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

?>
