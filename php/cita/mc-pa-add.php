<?php

include_once '../../dbconnection.php';

    $id_cita = $_POST['id_cita'];
    $motivo_con = mb_strtoupper($_POST['motivo_con']);
    $problema_act = mb_strtoupper($_POST['problema_act']);

    $query = "UPDATE cita SET motivo_con = '$motivo_con', problema_act = '$problema_act' WHERE id_cita = '$id_cita'";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

  echo "Motivo de la consulta y Problema Actual añadidos exitósamente"; 
?>