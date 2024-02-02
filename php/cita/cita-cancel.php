<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';
$conteo=2;
$id_caso=0;
 $id_cita = $_POST['id_cita'];
    $query = "Select id_caso FROM cita WHERE id_cita = '$id_cita'";
    $result = mysqli_query($conn, $query);
      if(!$result) {
        die('Error en consulta '.mysqli_error($conn));
      }
      else
      {
           while($row = mysqli_fetch_array($result)) 
           {
                $id_caso = $row['id_caso'];
                $query2 = "Select count(id_caso) as conteo FROM cita WHERE id_caso = '$id_caso'";
                $result2 = mysqli_query($conn, $query2);
                while($row2 = mysqli_fetch_array($result2)) 
                {
                   $conteo = $row2['conteo'];
                    if($conteo<=1)
                    {
                       
                        $query3 = "DELETE FROM cita WHERE id_caso = '$id_caso'";
                        $result3 = mysqli_query($conn, $query3);
                    
                        if(!$result3) {
                         die('Error en consulta '.mysqli_error($conn));
                        }
                        $query4 = "DELETE FROM caso WHERE id_caso = '$id_caso'";
                        $result4 = mysqli_query($conn, $query4);
                    
                        if(!$result4) {
                         die('Error en consulta '.mysqli_error($conn));
                        }
                        echo "Se ha eliminado cita y caso exitosamente"; 
                    }
                    else
                    {
                       
                        echo $query5 = "UPDATE cita SET id = '$cita_cancelada' WHERE id_cita = '$id_cita'";
                        $result5 = mysqli_query($conn, $query5);
                    
                      if(!$result5) {
                        die('Error en consulta '.mysqli_error($conn));
                      }
                    
                      echo "Cita cancelada exitosamente"; 
                    }
                }
                
           }
      }


?>
