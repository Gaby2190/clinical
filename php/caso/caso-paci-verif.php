<?php
include_once '../../dbconnection.php';
include_once '../../variables.php';

    $id_medico = $_POST['id_medico'];
    $id_especialidad = $_POST['id_especialidad'];
    $id_paciente = $_POST['id_paciente'];
 
    $query = "SELECT id_caso FROM caso WHERE id_medico = '{$id_medico}' AND id_especialidad = '$id_especialidad' AND id_paciente = '{$id_paciente}' AND id=1";
  

    $result = mysqli_query($conn, $query);

    if(!$result) {
        die('Error en consulta '.mysqli_error($conn));
    }

    $json = array();

    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id_caso' => $row['id_caso']
        );
    }

    if (empty($json)) {
        echo false;
    }else{
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }
?>