<?php

    include('../../dbconnection.php');
    include('../../variables.php');

    $id_caso = $_POST['id_caso'];
    $descripcion = mb_strtoupper($_POST['descripcion']);

    $query = "UPDATE caso SET descripcion = '$descripcion' WHERE id_caso = '$id_caso'";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

  echo "Descripción añadida exitósamente al caso"; 
?>
