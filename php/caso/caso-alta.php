<?php

    include('../../dbconnection.php');
    include('../../variables.php');

    $id_caso = $_POST['id_caso'];
    $c_alta = $_POST['c_alta'];
    $t_tratamiento = $_POST['t_tratamiento'];
    $proc_cq = mb_strtoupper($_POST['proc_cq']);
    $fecha_alta = $_POST['fecha_alta'];

    $query = "UPDATE caso SET 
    c_alta = '$c_alta', 
    t_tratamiento = '$t_tratamiento',
    proc_cq = '$proc_cq',
    id = '$caso_cerrado',
    fecha_alta = '$fecha_alta' 
    WHERE id_caso = '$id_caso'";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

  echo "Caso cerrado exitósamente"; 
?>
