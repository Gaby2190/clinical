<?php

    include('../../dbconnection.php');

    $id_medico = $_POST['id_medico'];
    $cedula_medi = $_POST['cedula_medi'];
    $nombres_medi = mb_strtoupper($_POST['nombres_medi']);
    $apellidos_medi = mb_strtoupper($_POST['apellidos_medi']);
    $nom_ape_medi = mb_strtoupper($_POST['nom_ape_medi']);
    $telefono_medi = $_POST['telefono_medi'];
    $celular_medi = $_POST['celular_medi'];
    $correo_medi = $_POST['correo_medi'];
    $direccion_medi = mb_strtoupper($_POST['direccion_medi']);
    $nautorizacion_medi = $_POST['nautorizacion_medi'];
    $tarifa = $_POST['tarifa'];
    $tarifa_control = $_POST['tarifa_control'];
    $pago_ingreso = $_POST['pago_ingreso'];
    $comision_c = $_POST['comision_c'];
    $comision_a = $_POST['comision_a'];
    $tiempo_ap = $_POST['tiempo_ap'];
    $id_usuario = $_POST['id_usuario'];
    $usuario = 'M'.$cedula_medi;
 
    $query1 = "UPDATE medico SET cedula_medi = '$cedula_medi', nombres_medi = '$nombres_medi', apellidos_medi = '$apellidos_medi', nom_ape_medi = '$nom_ape_medi', telefono_medi = '$telefono_medi', celular_medi = '$celular_medi', correo_medi = '$correo_medi', direccion_medi = '$direccion_medi', nautorizacion_medi = '$nautorizacion_medi', tarifa = '$tarifa', tarifa_control = '$tarifa_control', pago_ingreso = '$pago_ingreso', comision_c = '$comision_c', comision_a = '$comision_a', tiempo_ap = '$tiempo_ap' WHERE id_medico = '$id_medico'";
    $query2 = "UPDATE usuario SET usuario = '$usuario' WHERE id_usuario = '$id_usuario'";
    
    $result1 = mysqli_query($conn, $query1);
    $result2 = mysqli_query($conn, $query2);

    $result = $result1." ".$result2;

    if (!$result) {
    die('Actualización Fallida');
    }
    echo "Datos de médico modificados satisfactoriamente"; 


?>
