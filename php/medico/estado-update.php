<?php

    include('../../dbconnection.php');

    $id_usuario = $_POST['id_usuario'];
    $id_medico = $_POST['id_medico'];
    $estado = $_POST['estado'];
  
    
    if ($estado == 'true') {
       
        $query1 = "UPDATE medico SET estado_medi = 1 WHERE id_medico = '$id_medico'";
        $query2 = "UPDATE usuario SET estado_usr = 1 WHERE id_usuario = '$id_usuario'";
      
        $result1 = mysqli_query($conn, $query1);
        $result2 = mysqli_query($conn, $query2);

        $result = $result1." ".$result2;
  
        if (!$result) {
        die('Actualización Fallida');
        }
        echo "Estado modificado satisfactoriamente a ACTIVO/A"; 
    }
    else
    {
        $query1 = "UPDATE medico SET estado_medi = 0 WHERE id_medico = '$id_medico'";
        $query2 = "UPDATE usuario SET estado_usr = 0 WHERE id_usuario = '$id_usuario'";
       
        $result1 = mysqli_query($conn, $query1);
        $result2 = mysqli_query($conn, $query2);

        $result = $result1." ".$result2;
  
        if (!$result) {
        die('Actualización Fallida');
        }
        echo "Estado modificado satisfactoriamente a INACTIVO/A";
    }


?>
