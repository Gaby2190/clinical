<?php

    include('../../dbconnection.php');

    $cedula_rece = $_POST['cedula_rece'];
    $nombres_rece = mb_strtoupper($_POST['nombres_rece']);
    $apellidos_rece = mb_strtoupper($_POST['apellidos_rece']);
    $telefono_rece = $_POST['telefono_rece'];
    $celular_rece = $_POST['celular_rece'];
    $correo_rece = $_POST['correo_rece'];
    $direccion_rece = mb_strtoupper($_POST['direccion_rece']);
    $imagen = $_POST['imagen'];
    $id_usuario = $_POST['id_usuario'];


    $query = "INSERT into recepcionista(cedula_rece, nombres_rece,apellidos_rece,telefono_rece,celular_rece,correo_rece,direccion_rece,imagen,id_usuario) 
            VALUES ('$cedula_rece', '$nombres_rece','$apellidos_rece','$telefono_rece','$celular_rece','$correo_rece','$direccion_rece','$imagen','$id_usuario')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Recepcionista registrado exitosamente";  


?>
