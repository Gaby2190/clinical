<?php

    include('../../dbconnection.php');
    include('../../variables.php');

    $id_caso = $_POST['id_caso'];
    $query = "SELECT efr.*, ci.tipo_cita, ci.id_caso
              FROM examen_fr AS efr
              INNER JOIN cita as ci
                ON efr.id_cita = ci.id_cita
              WHERE ci.id_caso = '{$id_caso}' AND ci.tipo_cita = '{$c_normal}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_examen_fr' => $row['id_examen_fr'],
        'examen_fr' => $row['examen_fr'],
        'cp' => $row['cp'],
        'descripcion' => $row['descripcion']
        );
    }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
