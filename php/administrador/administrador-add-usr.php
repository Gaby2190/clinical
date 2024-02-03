<?php

include_once '../../dbconnection.php';


    $usuario = mysqli_real_escape_string($conn,$_POST['usuario']);
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
    $fecha_registro = mysqli_real_escape_string($conn,$_POST['fecha_registro']);
    $estado_usr = mysqli_real_escape_string($conn,$_POST['estado_usr']);
    $id_rol = mysqli_real_escape_string($conn,$_POST['id_rol']);


    $query = "INSERT into usuario(usuario, clave, fecha_registro, estado_usr, id_rol) VALUES ('$usuario', '$clave', '$fecha_registro', '$estado_usr', '$id_rol')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "El usuario y contraseña se han registrados con éxito";  


?>
