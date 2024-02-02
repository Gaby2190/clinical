<?php

include_once '../../dbconnection.php';


    $id_cita = $_POST['id_cita'];
    $signos_a = mb_strtoupper($_POST['signos_a']);
    $recomendaciones_nf = mb_strtoupper($_POST['recomendaciones_nf']);
    $evolucion = mb_strtoupper($_POST['evolucion']);
    $t_contingencia = $_POST['t_contingencia'];
    $dias_reposo = $_POST['dias_reposo'];


    $query = "UPDATE cita 
    SET signos_a = '$signos_a',
        recomendaciones_nf = '$recomendaciones_nf',
        evolucion = '$evolucion',
        dias_reposo = '$dias_reposo',
        t_contingencia = '$t_contingencia'
    WHERE id_cita = '$id_cita'";
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

  echo "Signos de alarma, recomendaciones no farmacológicas, dias reposo y evolución añadidos exitósamente"; 
?>
