<?php
    include('../../dbconnection.php');
    $fecha_registro = $_POST['fecha_registro'];
    $id_medico = $_POST['id_medico'];
    $id_especialidad = $_POST['id_especialidad'];
    $id_paciente = $_POST['id_paciente'];
    $id = $_POST['id'];
   $query = "INSERT into caso(fecha_registro,id_medico,id_especialidad,id_paciente,id) 
            VALUES ('$fecha_registro','$id_medico','$id_especialidad','$id_paciente','$id')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
        echo "fallo";
    }

    echo "Caso registrado exitosamente";  
?>