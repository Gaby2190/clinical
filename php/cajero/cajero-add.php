<?php

include_once '../../dbconnection.php';

    $cedula_caje = $_POST['cedula_caje'];
    $nombres_caje = mb_strtoupper($_POST['nombres_caje']);
    $apellidos_caje = mb_strtoupper($_POST['apellidos_caje']);
    $telefono_caje = $_POST['telefono_caje'];
    $celular_caje = $_POST['celular_caje'];
    $correo_caje = $_POST['correo_caje'];
    $direccion_caje = mb_strtoupper($_POST['direccion_caje']);
    $imagen = $_POST['imagen'];
    $id_usuario = $_POST['id_usuario'];


    $query = "INSERT into cajero(cedula_caje, nombres_caje,apellidos_caje,telefono_caje,celular_caje,correo_caje,direccion_caje,imagen,id_usuario) 
            VALUES ('$cedula_caje', '$nombres_caje','$apellidos_caje','$telefono_caje','$celular_caje','$correo_caje','$direccion_caje','$imagen','$id_usuario')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Cajero/a registrado exitosamente";  


?>
