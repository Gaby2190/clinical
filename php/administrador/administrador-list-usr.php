<?php

include_once '../../dbconnection.php';


if(isset($_POST['usuario'])) {

  $usuario = $_POST['usuario'];
 
  $query = "SELECT * from usuario where usuario = '{$usuario}'";
  $result = mysqli_query($conn, $query);

  if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_usuario' => $row['id_usuario'],
        'usuario' => $row['usuario'],
        'clave' => $row['clave'],
        'fecha_registro' => $row['fecha_registro'],
        'estado_usr' => $row['estado_usr'],
        'id_rol' => $row['id_rol']
        );
        
    }

    if (empty($json)) {
      echo false;
    }else{
      $jsonstring = json_encode($json[0]);
      echo $jsonstring;
    }   
}
?>
