<?php

include('../../dbconnection.php');
include_once("../../variables.php");

    $id_paciente = $_POST['id_paciente'];
    $id_medico = $_POST['id_medico'];
    $query = "SELECT ca.*,m.sufijo, m.nombres_medi, m.apellidos_medi
              FROM caso AS ca
              INNER JOIN medico AS m
                  ON m.id_medico = ca.id_medico
              WHERE ca.id_paciente = '{$id_paciente}' and ca.id_medico = '{$id_medico}' and ca.id = '{$caso_abierto}'";
 
    $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id_caso' => $row['id_caso'],
          'descripcion' => $row['descripcion'],
          'fecha_registro' => $row['fecha_registro'],
          'id_medico' => $row['id_medico'],
          'id_paciente' => $row['id_paciente'],
          'id' => $row['id'],
          'sufijo' => $row['sufijo'],
          'nombres_medi' => $row['nombres_medi'],
          'apellidos_medi' => $row['apellidos_medi']
        );
        
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;

?>
