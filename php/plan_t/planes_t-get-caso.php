<?php
    include('../../dbconnection.php');

    $id_caso = $_POST['id_caso_g'];

    $query = "SELECT pt.*, ci.fecha, ci.id_cita
              FROM plan_t as pt
              INNER JOIN cita as ci
                ON pt.id_cita = ci.id_cita
              WHERE ci.id_caso = '{$id_caso}' ORDER BY ci.fecha DESC";
    $result = mysqli_query($conn, $query);

    if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id_cita' => $row['id_cita'],
            'fecha' => $row['fecha'],
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
