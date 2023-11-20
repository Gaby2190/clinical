<?php

include('../dbconnection.php');
include('../variables.php');

    $id_cita = $_POST['id_cita'];
    $query = "UPDATE cita SET actualizacion = '$datos_actualizados' WHERE id_cita = '$id_cita'";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

  echo "Datos para cita actualizados con éxito"; 
?>
