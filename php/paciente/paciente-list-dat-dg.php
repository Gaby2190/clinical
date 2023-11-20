<?php

include('../../dbconnection.php');

if(isset($_POST['id_usuario'])) {

  $id_usuario = $_POST['id_usuario'];
  
  $inicial=substr($id_usuario,0,1);
  if($inicial==0)
  {
      $id_usuario= substr($id_usuario,1,9);
  }
 
  $query = "SELECT * from datagroup where cedula = '{$id_usuario}'";
    
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id_paciente' => $row['id'],
          'cedula_paci' => $row['cedula'],
          'nombres_paci1' => trim($row['nombre1']),
          'apellidos_paci1' => trim($row['nombre2']),
          'nombres_paci2' => trim($row['apellido1']),
          'apellidos_paci2' => trim($row['apellido2']),
          'fechan_paci' => $row['fecha_nac'],
          'celular_paci' => $row['celular'],
          'correo_paci' => $row['correo'],
          'direccion_paci' => $row['direccion']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

?>
