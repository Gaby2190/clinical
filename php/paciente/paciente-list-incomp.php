<?php

include_once '../../dbconnection.php';

if(isset($_POST['id_paciente'])) {

  $id_paciente = $_POST['id_paciente'];
 
 /* $query = "SELECT pa.*, gen.nombre as genero, gen.id as id_gen , nac.nombre as nacionalidad , san.nombre as sangre  
  from paciente as pa 
  INNER JOIN genero as gen 
      ON pa.gen_id = gen.id
  INNER JOIN nacionalidad as nac  
      ON pa.nac_id = nac.id
  INNER JOIN sangre as san 
      ON pa.san_id = san.id
  where id_paciente = '$id_paciente'";
  */

  $query = "SELECT pa.*, gen.nombre as genero, gen.id as id_gen , nac.nombre as nacionalidad 
  from paciente as pa 
  INNER JOIN genero as gen 
      ON pa.gen_id = gen.id
  INNER JOIN nacionalidad as nac  
      ON pa.nac_id = nac.id
 
  where id_paciente = '$id_paciente'";

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
          'nacionalidad' => $row['nacionalidad'],
          'genero' => $row['genero'],
          'id_gen' => $row['id_gen'],
          'id_usuario' => $row['id_usuario']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

?>
