<?php

include_once '../../dbconnection.php';

    $id_usuario = $_POST['id_usuario'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);

    $query = "UPDATE usuario SET clave = '$clave' WHERE id_usuario = '$id_usuario'";
    $result = mysqli_query($conn, $query);
  
    if (!$result) {
      die('Actualización Fallida');
    }
    echo "Clave de usuario actualizada con éxito"; 


?>
