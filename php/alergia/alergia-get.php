<?php

include_once '../../dbconnection.php';


    $id_paciente = $_POST['id_paciente'];

    $query = "SELECT al.*,m.sufijo, m.nombres_medi, m.apellidos_medi
              FROM alergia AS al
              INNER JOIN medico AS m
                  ON m.id_medico = al.id_medico
              WHERE al.id_paciente = '{$id_paciente}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_alergia' => $row['id_alergia'],
        'fecha' => $row['fecha'],
        'descripcion' => $row['descripcion'],
        'id_medico' => $row['id_medico'],
        'id_paciente' => $row['id_paciente'],
        'sufijo' => $row['sufijo'],
        'nombres_medi' => $row['nombres_medi'],
        'apellidos_medi' => $row['apellidos_medi']
        );
    }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
