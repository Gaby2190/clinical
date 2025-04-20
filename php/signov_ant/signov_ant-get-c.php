<?php

include_once '../../dbconnection.php';

    $id_caso = $_POST['id_caso'];
    $id_cita = $_POST['id_cita'];

    $query = "SELECT sva.*, ci.id_cita, ci.id_caso 
              FROM signov_ant as sva 
              INNER JOIN cita as ci 
                ON sva.id_cita = ci.id_cita 
              WHERE ci.id_caso = '{$id_caso}'   AND ci.id_cita <> '{$id_cita}' ORDER BY ci.fecha ASC";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'fecha' => $row['fecha'],
        'hora' => $row['hora'],
        'temperatura' => $row['temperatura'],
        'presion_as' => $row['presion_as'],
        'presion_ad' => $row['presion_ad'],
        'pulso' => $row['pulso'],
        'frecuencia_r' => $row['frecuencia_r'],
        'frecuencia_c' => $row['frecuencia_c'],
        'sat_o' => $row['sat_o'],
        'peso' => $row['peso'],
        'talla' => $row['talla'],
        'perimetro' => $row['perimetro_c'],
        'p_abdominal' => $row['p_abdominal'],
        'h_capilar' => $row['h_capilar'],
        'g_capilar' => $row['g_capilar'],
        'pulsio' => $row['pulsio']
        );
    }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
