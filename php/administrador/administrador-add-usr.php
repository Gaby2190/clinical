<?php

include_once '../../dbconnection.php';


    $usuario = $_POST['usuario'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
    $fecha_registro = $_POST['fecha_registro'];
    $estado_usr = $_POST['estado_usr'];
    $id_rol = $_POST['id_rol'];


    $query = "INSERT into usuario(usuario, clave, fecha_registro, estado_usr, id_rol) VALUES ('$usuario', '$clave', '$fecha_registro', '$estado_usr', '$id_rol')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "El usuario y contraseña se han registrados con éxito";  


?>
