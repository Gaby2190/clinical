<?php

include_once '../../dbconnection.php';

    $cedula_asis = $_POST['cedula_asis'];
    $nombres_asis = mb_strtoupper($_POST['nombres_asis']);
    $apellidos_asis = mb_strtoupper($_POST['apellidos_asis']);
    $telefono_asis = $_POST['telefono_asis'];
    $celular_asis = $_POST['celular_asis'];
    $correo_asis = $_POST['correo_asis'];
    $direccion_asis = mb_strtoupper($_POST['direccion_asis']);
    $imagen = $_POST['imagen'];
    $id_usuario = $_POST['id_usuario'];


    $query = "INSERT into asistente(cedula_asis, nombres_asis,apellidos_asis,telefono_asis,celular_asis,correo_asis,direccion_asis,imagen,id_usuario) 
            VALUES ('$cedula_asis', '$nombres_asis','$apellidos_asis','$telefono_asis','$celular_asis','$correo_asis','$direccion_asis','$imagen','$id_usuario')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Asistente registrado exitosamente";  


?>
