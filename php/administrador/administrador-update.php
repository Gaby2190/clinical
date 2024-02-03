<?php

include_once '../../dbconnection.php';


    $id_administrador = mysqli_real_escape_string($conn,$_POST['id_administrador']);
    $cedula_admin = mysqli_real_escape_string($conn,$_POST['cedula_admin']);
    $nombres_admin = mb_strtoupper(mysqli_real_escape_string($conn,$_POST['nombres_admin']));
    $apellidos_admin = mb_strtoupper(mysqli_real_escape_string($conn,$_POST['apellidos_admin']));
    $telefono_admin = mysqli_real_escape_string($conn,$_POST['telefono_admin']);
    $celular_admin = mysqli_real_escape_string($conn,$_POST['celular_admin']);
    $correo_admin = mysqli_real_escape_string($conn,$_POST['correo_admin']);
    $direccion_admin = mb_strtoupper(mysqli_real_escape_string($conn,$_POST['direccion_admin']));
    $id_usuario = mysqli_real_escape_string($conn,$_POST['id_usuario']);
    $usuario = 'A'.$cedula_admin;
    //$estado_admin = $_POST['estado_admin'];
    //$imagen = $_POST['imagen'];

    $query1 = "UPDATE administrador SET cedula_admin = '$cedula_admin', nombres_admin = '$nombres_admin', apellidos_admin = '$apellidos_admin', telefono_admin = '$telefono_admin', celular_admin = '$celular_admin', correo_admin = '$correo_admin', direccion_admin = '$direccion_admin' WHERE id_administrador = '$id_administrador'";
    $query2 = "UPDATE usuario SET usuario = '$usuario' WHERE id_usuario = '$id_usuario'";
    
    $result1 = mysqli_query($conn, $query1);
    $result2 = mysqli_query($conn, $query2);

    $result = $result1." ".$result2;

    if (!$result) {
    die('Actualización Fallida');
    }
    echo "Datos de administrador modificados satisfactoriamente"; 


?>
