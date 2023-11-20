<?php

    include('../../dbconnection.php');
    include('../../variables.php');

    $id_cita = $_POST['id_cita'];
    $descuento = $_POST['descuento'];

    $query = "UPDATE cita SET descuento = '$descuento' WHERE id_cita = '$id_cita'";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

  echo "Descuento añadido exitósamente a la cita"; 
?>
