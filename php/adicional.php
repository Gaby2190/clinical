<?php
   include_once '../dbconnection.php';

    $descripcion = mb_strtoupper($_POST['descripcion']);
    $costo = $_POST['costo'];
    $id_cita = $_POST['id_cita'];
    $id = $_POST['id'];


    $query = "DELETE FROM  adicional WHERE id_cita ='$id_cita';";
    $result = mysqli_query($conn, $query);

    

    $query = "INSERT into adicional(descripcion,costo,id_cita,id) VALUES ('$descripcion','$costo','$id_cita','$id')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Servicio adicional registrado con éxito";  
?>