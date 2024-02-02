<?php

include_once '../../dbconnection.php';

    $id_cita = $_POST['id_cita'];

    $query = "SELECT * FROM signov_ant WHERE id_cita = '{$id_cita}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'fecha' => $row['fecha'],
        'temperatura' => $row['temperatura'],
        'presion_as' => $row['presion_as'],
        'presion_ad' => $row['presion_ad'],
        'pulso' => $row['pulso'],
        'frecuencia_r' => $row['frecuencia_r'],
        'frecuencia_c' => $row['frecuencia_c'],
        'sat_o' => $row['sat_o'],
        'peso' => $row['peso'],
        'talla' => $row['talla'],
        'perimetro' => $row['perimetro_c']
        );
    }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
