<?php

include_once '../dbconnection.php';
include_once '../variables.php';

    $id_cita = $_POST['id_cita'];
    $query = "UPDATE cita SET id = '$cita_finalizada' WHERE id_cita = '$id_cita'";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

  echo "La cita ha sido finalizada con éxito"; 
?>
