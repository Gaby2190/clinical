<?php

    include('../../dbconnection.php');

    $id_recepcionista = $_POST['id_recepcionista'];
    $cedula_rece = $_POST['cedula_rece'];
    $nombres_rece = mb_strtoupper($_POST['nombres_rece']);
    $apellidos_rece = mb_strtoupper($_POST['apellidos_rece']);
    $telefono_rece = $_POST['telefono_rece'];
    $celular_rece = $_POST['celular_rece'];
    $correo_rece = $_POST['correo_rece'];
    $direccion_rece = mb_strtoupper($_POST['direccion_rece']);
    $id_usuario = $_POST['id_usuario'];
    $usuario = 'R'.$cedula_rece;
    //$estado_rece = $_POST['estado_rece'];
    //$imagen = $_POST['imagen'];

    $query1 = "UPDATE recepcionista SET cedula_rece = '$cedula_rece', nombres_rece = '$nombres_rece', apellidos_rece = '$apellidos_rece', telefono_rece = '$telefono_rece', celular_rece = '$celular_rece', correo_rece = '$correo_rece', direccion_rece = '$direccion_rece' WHERE id_recepcionista = '$id_recepcionista'";
    $query2 = "UPDATE usuario SET usuario = '$usuario' WHERE id_usuario = '$id_usuario'";
    
    $result1 = mysqli_query($conn, $query1);
    $result2 = mysqli_query($conn, $query2);

    $result = $result1." ".$result2;

    if (!$result) {
    die('Actualización Fallida');
    }
    echo "Datos de recepcionista modificados satisfactoriamente"; 


?>
