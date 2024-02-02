<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';

    $cedula_medi = $_POST['cedula_medi'];
    $gen_id = $_POST['gen_id'];
    $sufijo = '';
    if (intval($_POST['gen_id'])==$gen_m) {
        $sufijo = 'DR.';
    }else{
        $sufijo = 'DRA.';
    }
    $nombres_medi = mb_strtoupper($_POST['nombres_medi']);
    $apellidos_medi = mb_strtoupper($_POST['apellidos_medi']);
    $nom_ape_medi = mb_strtoupper($_POST['nom_ape_medi']);
    $telefono_medi = $_POST['telefono_medi'];
    $celular_medi = $_POST['celular_medi'];
    $correo_medi = $_POST['correo_medi'];
    $direccion_medi = mb_strtoupper($_POST['direccion_medi']);
    $nautorizacion_medi = $_POST['nautorizacion_medi'];
    $estado_medi = $_POST['estado_medi'];
    $imagen = $_POST['imagen'];
    $tarifa = $_POST['tarifa'];
    $tarifa_control = $_POST['tarifa_control'];
    $pago_ingreso = $_POST['pago_ingreso'];
    $comision_c = $_POST['comision_c'];
    $comision_a = $_POST['comision_a'];
    $tiempo_ap = $_POST['tiempo_ap'];
    $id_usuario = $_POST['id_usuario'];


    $query = "INSERT into medico(cedula_medi,sufijo, nombres_medi,apellidos_medi,nom_ape_medi,telefono_medi,celular_medi,correo_medi,direccion_medi,nautorizacion_medi,estado_medi,imagen, tarifa,tarifa_control, pago_ingreso, comision_c, comision_a, tiempo_ap,gen_id,id_usuario) 
            VALUES ('$cedula_medi','$sufijo', '$nombres_medi','$apellidos_medi','$nom_ape_medi','$telefono_medi','$celular_medi','$correo_medi','$direccion_medi','$nautorizacion_medi','$estado_medi','$imagen', '$tarifa','$tarifa_control' ,'$pago_ingreso', '$comision_c', '$comision_a', '$tiempo_ap','$gen_id','$id_usuario')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Médico registrado exitosamente";  


?>
