<?php
    include_once '../../dbconnection.php'; //Llama la conexion a la base de datos
   // Recibe los parametros por el POST
    $fecha_registro = $_POST['fecha_registro'];
    $id_medico = $_POST['id_medico'];
    $id_especialidad = $_POST['id_especialidad'];
    $id_paciente = $_POST['id_paciente'];
    $id = $_POST['id'];
   //Crea la consulta SQL
   $query = "INSERT into caso(fecha_registro,id_medico,id_especialidad,id_paciente,id) 
            VALUES ('$fecha_registro','$id_medico','$id_especialidad','$id_paciente','$id')";
   
   //Ejecuta la consulta SQL a la base de datos
   $result = mysqli_query($conn, $query);
   $id = mysqli_insert_id($conn);

   //Valida si la consulta fue fallida
    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    //En caso exitoso devuele el mensaje caso registrado exitosamente
    echo $id;
?>