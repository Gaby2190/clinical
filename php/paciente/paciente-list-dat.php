<?php

include_once '../../dbconnection.php';

if(isset($_POST['id_usuario'])) {

  $id_usuario = $_POST['id_usuario'];
 
  $query = "SELECT * from paciente where id_usuario = '{$id_usuario}'";
    
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id_paciente' => $row['id_paciente'],
          'cedula_paci' => $row['cedula_paci'],
          'nombres_paci1' => trim($row['nombres_paci1']),
          'apellidos_paci1' => trim($row['apellidos_paci1']),
          'nombres_paci2' => trim($row['nombres_paci2']),
          'apellidos_paci2' => trim($row['apellidos_paci2']),
          'fechan_paci' => $row['fechan_paci'],
          'telefono_paci' => $row['telefono_paci'],
          'celular_paci' => $row['celular_paci'],
          'correo_paci' => $row['correo_paci'],
          'direccion_paci' => $row['direccion_paci'],
          'imagen' => $row['imagen'],
          'contacto_nom' => $row['contacto_nom'],
          'contacto_ape' => $row['contacto_ape'],
          'contacto_par' => $row['contacto_par'],
          'contacto_num' => $row['contacto_num'],
          'san_id' => $row['san_id'],
          'nac_id' => $row['nac_id'],
          'gen_id' => $row['gen_id'],
          'id_usuario' => $row['id_usuario']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

?>
