<?php

include_once '../../dbconnection.php';


    $id_segu = $_POST['id_segu'];
    $id_medico = $_POST['id_medico'];
    $valor = $_POST['valor'];
  
    
    
    $query = "UPDATE asegu_med SET valor = $valor WHERE id = '$id_segu'";
       
        $result = mysqli_query($conn, $query);
     
  
        if (!$result) {
        die('Actualización Fallida');
        }
        echo "Valor Actualizado Correctamente";
    


?>
