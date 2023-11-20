<?php

    include('../../dbconnection.php');

    $id_asistente = $_POST['id_asistente'];
    $cedula_asis = $_POST['cedula_asis'];
    $nombres_asis = mb_strtoupper($_POST['nombres_asis']);
    $apellidos_asis = mb_strtoupper($_POST['apellidos_asis']);
    $telefono_asis = $_POST['telefono_asis'];
    $celular_asis = $_POST['celular_asis'];
    $correo_asis = $_POST['correo_asis'];
    $direccion_asis = mb_strtoupper($_POST['direccion_asis']);
    $id_usuario = $_POST['id_usuario'];
    $usuario = 'AS'.$cedula_asis;
    //$estado_asis = $_POST['estado_asis'];
    //$imagen = $_POST['imagen'];

    $query1 = "UPDATE asistente SET cedula_asis = '$cedula_asis', nombres_asis = '$nombres_asis', apellidos_asis = '$apellidos_asis', telefono_asis = '$telefono_asis', celular_asis = '$celular_asis', correo_asis = '$correo_asis', direccion_asis = '$direccion_asis' WHERE id_asistente = '$id_asistente'";
    $query2 = "UPDATE usuario SET usuario = '$usuario' WHERE id_usuario = '$id_usuario'";
    
    $result1 = mysqli_query($conn, $query1);
    $result2 = mysqli_query($conn, $query2);

    $result = $result1." ".$result2;

    if (!$result) {
    die('Actualización Fallida');
    }
    echo "Datos del asistente modificados satisfactoriamente"; 


?>
