<?php

    include('../../dbconnection.php');
    include('../../variables.php');

    $id_caso = $_POST['id_caso'];
    $query = "SELECT ros.*, ci.tipo_cita, ci.id_caso
              FROM revision_o_s as ros
              INNER JOIN cita as ci
                ON ros.id_cita = ci.id_cita
              WHERE ci.id_caso = '{$id_caso}' AND ci.tipo_cita = '{$c_normal}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_orga_sist' => $row['id_orga_sist'],
        'orga_sist' => $row['orga_sist'],
        'cp' => $row['cp'],
        'descripcion' => $row['descripcion']
        );
    }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
