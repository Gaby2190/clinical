<?php

include_once '../../dbconnection.php';


    $id_paciente = mysqli_real_escape_string($conn,$_POST['id_paciente']);

    $query = "SELECT an.*, en.nombre
              FROM antecedente_f AS an
              INNER JOIN enfermedad AS en
                  ON en.id = an.id_enfermedad
              WHERE an.id_paciente = '{$id_paciente}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_antecedente' => $row['id_antecedente'],
        'parentesco' => $row['parentesco'],
        'descripcion' => $row['descripcion'],
        'id_paciente' => $row['id_paciente'],
        'id_enfermedad' => $row['id_enfermedad'],
        'nombre' => $row['nombre']
        );
    }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
