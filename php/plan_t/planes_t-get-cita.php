<?php
include_once '../../dbconnection.php';

    $id_cita = $_POST['id_cita'];

    $query = "SELECT pt.*
              FROM plan_t as pt
              WHERE pt.id_cita = '{$id_cita}'";
    $result = mysqli_query($conn, $query);

    if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id_cita' => $row['id_cita'],
            'id_plan_t' => $row['id_plan_t'],
            'datos_m' => $row['datos_m'],
            'via_a' => $row['via_a'],
            'cantidad' => $row['cantidad'],
            'indicaciones' => $row['indicaciones']
        );
    }

    if (empty($json)) {
        echo false;
    }else{
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
?>
