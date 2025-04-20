<?php

include_once '../../dbconnection.php';

    $id_caso = $_POST['id_caso'];
 
    $query = "SELECT di.*, ci.id_caso, ci.fecha, cie.clave, me.sufijo, me.nombres_medi, me.apellidos_medi
                FROM diagnostico AS di
                INNER JOIN cita AS ci
                    ON di.id_cita = ci.id_cita
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                INNER JOIN medico AS me
                    ON ca.id_medico = me.id_medico
                INNER JOIN diagnosticoscie10 AS cie
                    ON di.id_cie = cie.id
                WHERE ci.id_caso = '{$id_caso}'";

    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }
 
    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_diagnostico' => $row['id_diagnostico'],
        'descripcion' => $row['descripcion'],
        'fecha' => $row['fecha'],
        'clave' => $row['clave'],
        'pre_def' => $row['pre_def'],
        'diagnostico_esp' => $row['diagnostico_esp'],
        'sufijo' => $row['sufijo'],
        'nombres_medi' => $row['nombres_medi'],
        'apellidos_medi' => $row['apellidos_medi'],
        'id_cie' => $row['id_cie'],
        'id_cita' => $row['id_cita']
        );
    }
  
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
