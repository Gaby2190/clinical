<?php
include_once '../../dbconnection.php';
include_once '../../variables.php';
    $id_medico = $_POST['id_medico'];

    $query = "SELECT pa.* 
    FROM paciente as pa
    INNER JOIN caso as ca
      ON pa.id_paciente = ca.id_paciente 
    INNER JOIN cita as ci
      ON ca.id_caso = ci.id_caso
    WHERE (ci.id = '$cita_agendada' or ci.id = '$cita_reagendada') AND ca.id_medico = '$id_medico' GROUP BY pa.cedula_paci ORDER BY nombres_paci1 ASC";


    $result = mysqli_query($conn, $query);

    if(!$result) {
      die('Consulta fallida'. mysqli_error($conn));
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
        'id_usuario' => $row['id_usuario'],
        'barrio_paci' => $row['barrio_paci'],
        'parroquia_paci' => $row['parroquia_paci'],
        'canton_paci' => $row['canton_paci'],
        'provincia_paci' => $row['provincia_paci'],
        'zona_paci' => $row['zona_paci'],
        'lnacimiento_paci' => $row['lnacimiento_paci'],
        'gcultural_paci' => $row['gcultural_paci'],
        'ecivil_paci' => $row['ecivil_paci'],
        'instruccion_paci' => $row['instruccion_paci'],
        'ocupacion_paci' => $row['ocupacion_paci'],
        'empresat_paci' => $row['empresat_paci'],
        'ssalud_paci' => $row['ssalud_paci'],
        'referido_paci' => $row['referido_paci'],
        'contacto_dir' => $row['contacto_dir']
      );
    }
    
      $jsonstring = json_encode($json);
      echo $jsonstring;
?>
