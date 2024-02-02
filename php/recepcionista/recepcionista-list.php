<?php

include_once '../../dbconnection.php';

if(isset($_POST['id_recepcionista'])) {

  $id_recepcionista = $_POST['id_recepcionista'];
 
  $query = "SELECT * from recepcionista where id_recepcionista = '{$id_recepcionista}'";
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id_recepcionista' => $row['id_recepcionista'],
            'cedula_rece' => $row['cedula_rece'],
            'nombres_rece' => $row['nombres_rece'],
            'apellidos_rece' => $row['apellidos_rece'],
            'telefono_rece' => $row['telefono_rece'],
            'celular_rece' => $row['celular_rece'],
            'correo_rece' => $row['correo_rece'],
            'direccion_rece' => $row['direccion_rece'],
            'imagen' => $row['imagen']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

?>
