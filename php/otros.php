<?php
   include_once '../dbconnection.php';

    $descripcion = mb_strtoupper($_POST['descripcion']);
    $costo = $_POST['costo'];
    $id_cita = $_POST['id_cita'];
   


    

    $query = "INSERT into otro_c (descripcion,costo,id_cita) VALUES ('$descripcion','$costo','$id_cita')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Servicio enfermeria registrado con éxito";  
?>