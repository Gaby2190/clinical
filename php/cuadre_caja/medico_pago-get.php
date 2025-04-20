<?php

include_once '../../dbconnection.php';

   $fecha = $_POST['fecha'];
   $id_usuario = $_POST['id_usuario'];

   $query = "SELECT me_p.*, me.sufijo, me.nom_ape_medi ,fp.nombre
             FROM medico_pago as me_p
             INNER JOIN pago as pa
                ON me_p.id_pago = pa.id_pago
             INNER JOIN f_pago as fp
             	ON fp.id=me_p.id_f_pago
             INNER JOIN medico as me
             	ON me.id_medico = pa.id_medico
             WHERE me_p.fecha_p = '{$fecha}' and pa.id_usuario = '{$id_usuario}' GROUP BY me_p.id_pago ORDER BY me_p.hora_p ASC";

   $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  } 

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'fecha_p' => $row['fecha_p'],
            'hora_p' => $row['hora_p'],
            'id_pago' => $row['id_pago'],
            'nombre' => $row['nombre'],
            'sufijo' => $row['sufijo'],
            'nom_ape_medi' => $row['nom_ape_medi'],
            'costo' => $row['costo']
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
    
?>