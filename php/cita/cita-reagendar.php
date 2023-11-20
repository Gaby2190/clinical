<?php

    include('../../dbconnection.php');
    include('../../variables.php');
    $id_cita = $_POST['id_cita'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];


    $query = "UPDATE cita SET id = '$cita_reagendada', fecha = '$fecha', hora = '$hora' WHERE id_cita = '$id_cita'";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

  echo "Cita reagendada exitosamente"; 
?>
