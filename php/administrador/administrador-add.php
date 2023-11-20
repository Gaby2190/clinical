<?php

    include('../../dbconnection.php');

    $cedula_admin = $_POST['cedula_admin'];
    $nombres_admin = mb_strtoupper($_POST['nombres_admin']);
    $apellidos_admin = mb_strtoupper($_POST['apellidos_admin']);
    $telefono_admin = $_POST['telefono_admin'];
    $celular_admin = $_POST['celular_admin'];
    $correo_admin = $_POST['correo_admin'];
    $direccion_admin = mb_strtoupper($_POST['direccion_admin']);
    $imagen = $_POST['imagen'];
    $id_usuario = $_POST['id_usuario'];


    $query = "INSERT into administrador(cedula_admin, nombres_admin,apellidos_admin,telefono_admin,celular_admin,correo_admin,direccion_admin,imagen,id_usuario) 
            VALUES ('$cedula_admin', '$nombres_admin','$apellidos_admin','$telefono_admin','$celular_admin','$correo_admin','$direccion_admin','$imagen','$id_usuario')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Administrador/a registrado exitosamente";  


?>
