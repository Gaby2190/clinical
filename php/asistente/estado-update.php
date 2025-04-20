<?php

include_once '../../dbconnection.php';

    $id_usuario = $_POST['id_usuario'];
    $estado = $_POST['estado'];
  
    
    if ($estado == 'true') {
       
        $query = "UPDATE usuario SET estado_usr = 1 WHERE id_usuario = '$id_usuario'";
      
        $result = mysqli_query($conn, $query);
  
        if (!$result) {
        die('Actualización Fallida');
        }
        echo "Estado modificado satisfactoriamente a ACTIVO/A"; 
    }
    else
    {
        $query = "UPDATE usuario SET estado_usr = 0 WHERE id_usuario = '$id_usuario'";
       
        $result = mysqli_query($conn, $query);
  
        if (!$result) {
        die('Actualización Fallida');
        }
        echo "Estado modificado satisfactoriamente a INACTIVO/A";
    }


?>
