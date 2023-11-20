<?php

    include('../../dbconnection.php');

    $id_paciente = $_POST['id_paciente'];

    $query = "SELECT an.*,m.sufijo, m.nombres_medi, m.apellidos_medi, enf.nombre
              FROM antecedente_p AS an
              INNER JOIN medico AS m
                  ON m.id_medico = an.id_medico
              INNER JOIN enfermedad AS enf
                  ON enf.id = an.id_enfermedad
              WHERE an.id_paciente = '{$id_paciente}'";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_antecedente' => $row['id_antecedente'],
        'descripcion' => $row['descripcion'],
        'fecha' => $row['fecha'],
        'id_paciente' => $row['id_paciente'],
        'id_medico' => $row['id_medico'],
        'sufijo' => $row['sufijo'],
        'nombres_medi' => $row['nombres_medi'],
        'apellidos_medi' => $row['apellidos_medi'],
        'nombre' => $row['nombre']
        );
    }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
