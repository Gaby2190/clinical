<?php

    include('../../dbconnection.php');

    $id_caso = $_POST['id_caso'];
    $motivo_con = mb_strtoupper($_POST['motivo_con']);
    $problema_act = mb_strtoupper($_POST['problema_act']);

    $query = "UPDATE caso SET motivo_con = '$motivo_con', problema_act = '$problema_act' WHERE id_caso = '$id_caso'";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

  echo "Motivo de la consulta y Problema Actual añadidos exitósamente"; 
?>
