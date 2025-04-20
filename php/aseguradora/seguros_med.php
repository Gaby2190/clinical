<?php

include_once '../../dbconnection.php';

$id_medico = $_POST['id_medico'];

  $query = "SELECT * FROM asegu_med as asm
  INNER JOIN aseguradora as ase ON ase.id=asm.id_seguro
   where id_medico= '{$id_medico}' 
   ORDER BY nombre ASC";//preparamos la consulta sql
    
  $result = mysqli_query($conn, $query);//ejecuta la consulta sql
  if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));//validamos un error en la consulta
  }

  $json = array();//creamos un aaray para almacenar el resultado
  while($row = mysqli_fetch_array($result)) {//recorremos el numero de filas del resultado
                                            //para llenar el array con el resultado de la consulta sql
    $json[] = array(
      'id' => $row['id'],
      'nombre' => $row['nombre']
    );
  }
  
    $jsonstring = json_encode($json);// se convierte el array en una cadena json
    echo $jsonstring;//se devuelve el resultado exitoso al caso_create.js
?>
