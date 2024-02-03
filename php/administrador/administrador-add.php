<?php

include_once '../../dbconnection.php';
  
    $cedula_admin = mysqli_real_escape_string($conn,$_POST['cedula_admin']);
    $nombres_admin = mb_strtoupper(mysqli_real_escape_string($conn,$_POST['nombres_admin']));
    $apellidos_admin = mb_strtoupper(mysqli_real_escape_string($conn,$_POST['apellidos_admin']));
    $telefono_admin = mysqli_real_escape_string($conn,$_POST['telefono_admin']);
    $celular_admin = mysqli_real_escape_string($conn,$_POST['celular_admin']);
    $correo_admin = mysqli_real_escape_string($conn,$_POST['correo_admin']);
    $direccion_admin = mb_strtoupper(mysqli_real_escape_string($conn,$_POST['direccion_admin']));
    $imagen = $_POST['imagen'];
    $id_usuario = mysqli_real_escape_string($conn,$_POST['id_usuario']);


    $query = "INSERT into administrador(cedula_admin, nombres_admin,apellidos_admin,telefono_admin,celular_admin,correo_admin,direccion_admin,imagen,id_usuario) 
            VALUES ('$cedula_admin', '$nombres_admin','$apellidos_admin','$telefono_admin','$celular_admin','$correo_admin','$direccion_admin','$imagen','$id_usuario')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Administrador/a registrado exitosamente";  


?>
