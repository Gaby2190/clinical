<?php

include_once '../../dbconnection.php';

  $id_caso = $_POST['id_caso'];
 
  $query = "SELECT ca.*, p.nombres_paci1, p.apellidos_paci1, p.nombres_paci2, p.apellidos_paci2, p.correo_paci, p.celular_paci, me.sufijo, me.nombres_medi, me.apellidos_medi, me.nom_ape_medi
            FROM caso AS ca
            INNER JOIN paciente AS p
                ON p.id_paciente = ca.id_paciente
            INNER JOIN medico AS me
                ON me.id_medico = ca.id_medico
            WHERE ca.id_caso = '{$id_caso}'";
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
          'nombres_paci1' => $row['nombres_paci1'],
          'apellidos_paci1' => $row['apellidos_paci1'],
          'nombres_paci2' => $row['nombres_paci2'],
          'apellidos_paci2' => $row['apellidos_paci2'],
          'correo_paci' => $row['correo_paci'],
          'celular_paci' => $row['celular_paci'],
          'sufijo' => $row['sufijo'],
          'nombres_medi' => $row['nombres_medi'],
          'apellidos_medi' => $row['apellidos_medi'],
          'nom_ape_medi' => $row['nom_ape_medi']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;

?>