<?php

    include('../../dbconnection.php');

    $id_cajero = $_POST['id_cajero'];
    $cedula_caje = $_POST['cedula_caje'];
    $nombres_caje = mb_strtoupper($_POST['nombres_caje']);
    $apellidos_caje = mb_strtoupper($_POST['apellidos_caje']);
    $telefono_caje = $_POST['telefono_caje'];
    $celular_caje = $_POST['celular_caje'];
    $correo_caje = $_POST['correo_caje'];
    $direccion_caje = mb_strtoupper($_POST['direccion_caje']);
    $id_usuario = $_POST['id_usuario'];
    $usuario = 'C'.$cedula_caje;
    //$estado_caje = $_POST['estado_caje'];
    //$imagen = $_POST['imagen'];

    $query1 = "UPDATE cajero SET cedula_caje = '$cedula_caje', nombres_caje = '$nombres_caje', apellidos_caje = '$apellidos_caje', telefono_caje = '$telefono_caje', celular_caje = '$celular_caje', correo_caje = '$correo_caje', direccion_caje = '$direccion_caje' WHERE id_cajero = '$id_cajero'";
    $query2 = "UPDATE usuario SET usuario = '$usuario' WHERE id_usuario = '$id_usuario'";
    
    $result1 = mysqli_query($conn, $query1);
    $result2 = mysqli_query($conn, $query2);

    $result = $result1." ".$result2;

    if (!$result) {
    die('Actualización Fallida');
    }
    echo "Datos de cajero modificados satisfactoriamente"; 


?>
