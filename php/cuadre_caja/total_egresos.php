<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

   $fecha = $_POST['fecha'];
   $id_usuario = $_POST['id_usuario'];
   $id_fpago = $_POST['id_fpago'];
   $query = "SELECT SUM(me_p.costo) as total ,fp.nombre
             FROM medico_pago as me_p
             INNER JOIN pago as pa
                ON me_p.id_pago = pa.id_pago
             INNER JOIN f_pago as fp
             	ON fp.id=me_p.id_f_pago
             INNER JOIN medico as me
             	ON me.id_medico = pa.id_medico
              WHERE me_p.fecha_p = '{$fecha}' and pa.id_usuario = '{$id_usuario}' and fp.id='{$id_fpago}'  ORDER BY fp.nombre ASC";
    $result = mysqli_query($conn, $query);
 
  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  } 

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'total' => $row['total'],
          'nombre' => $row['nombre']
        );
        
    }

    if (empty($json)) {
        echo false;
    }else{
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }
    
?>