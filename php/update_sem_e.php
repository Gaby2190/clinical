<?php

include_once '../dbconnection.php';

    $id_caso = $_POST['id_caso'];
    $semana_embarazo = $_POST['semana_embarazo'];

    $query = "UPDATE caso SET semana_embarazo = '$semana_embarazo' WHERE id_caso = '$id_caso'";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

  echo "Semana de embarazo actualizada con éxito"; 
?>
