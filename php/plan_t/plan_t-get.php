<?php
include_once '../../dbconnection.php';

    $id_cita = $_POST['id_cita'];

    $query = "SELECT * from plan_t where id_cita = '{$id_cita}'";
    $result = mysqli_query($conn, $query);

    if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'datos_m' => $row['datos_m'],
            'via_a' => $row['via_a'],
            'cantidad' => $row['cantidad'],
            'indicaciones' => $row['indicaciones'],
            'id_cita' => $row['id_cita']
        );
    }

    if (empty($json)) {
        echo "false";
    }else{
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }
?>
