<?php

include_once '../dbconnection.php';


    $id_cita = $_POST['id_cita'];
    $detalle_certificado = mb_strtoupper($_POST['detalle_certificado']);
    $query = "UPDATE cita SET detalle_certificado = '$detalle_certificado' WHERE id_cita = '$id_cita'";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

  echo "El detalle para el certificado médico para la cita se ha registrado con éxito"; 
?>