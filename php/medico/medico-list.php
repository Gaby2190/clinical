<?php

include_once '../../dbconnection.php';

if(isset($_POST['id_medico'])) {

  $id_medico = $_POST['id_medico'];
 
  $query = "SELECT * from medico where id_medico = '{$id_medico}'";
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id_medico' => $row['id_medico'],
            'cedula_medi' => $row['cedula_medi'],
            'nombres_medi' => ucwords(mb_strtolower($row['nombres_medi'])),
            'apellidos_medi' => ucwords(mb_strtolower($row['apellidos_medi'])),
            'nom_ape_medi' => ucwords(mb_strtolower($row['nom_ape_medi'])),
            'telefono_medi' => $row['telefono_medi'],
            'celular_medi' => $row['celular_medi'],
            'correo_medi' => $row['correo_medi'],
            'direccion_medi' => $row['direccion_medi'],
            'nautorizacion_medi' => $row['nautorizacion_medi'],
            'estado_medi' => $row['estado_medi'],
            'imagen' => $row['imagen'],
            'tarifa' => $row['tarifa'],
            'tarifa_control' => $row['tarifa_control'],
            'pago_ingreso' => $row['pago_ingreso'],
            'comision_c' => $row['comision_c'],
            'comision_a' => $row['comision_a'],
            'tiempo_ap' => $row['tiempo_ap']
        );
        
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

?>
