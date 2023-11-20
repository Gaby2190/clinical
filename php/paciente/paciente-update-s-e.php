<?php

    include('../../dbconnection.php'); 
 
    $id_paciente = $_POST['id_paciente'];
    $cedula_paci = $_POST['cedula_paci'];
    $nombres_paci1 = trim(mb_strtoupper($_POST['nombres_paci1']));
    $apellidos_paci1 = trim(mb_strtoupper($_POST['apellidos_paci1']));
    $nombres_paci2 = trim(mb_strtoupper($_POST['nombres_paci2']));
    $apellidos_paci2 = trim(mb_strtoupper($_POST['apellidos_paci2']));
    $fechan_paci = $_POST['fechan_paci'];
    $telefono_paci = $_POST['telefono_paci'];
    $celular_paci = $_POST['celular_paci'];
    $contacto_nom = mb_strtoupper($_POST['contacto_nom']);
    $contacto_ape = mb_strtoupper($_POST['contacto_ape']);
    $contacto_num = mb_strtoupper($_POST['contacto_num']);
    $contacto_par = mb_strtoupper($_POST['contacto_par']);
    $gen_id = $_POST['gen_id'];
    $contacto_dir = mb_strtoupper($_POST['contacto_dir']);
    $direccion_paci = mb_strtoupper($_POST['direccion_paci']);
    $ocupacion_paci = mb_strtoupper($_POST['ocupacion_paci']);
    $empresat_paci = mb_strtoupper($_POST['empresat_paci']);

    $id_usuario = $_POST['id_usuario'];
    $usuario = 'P'.$cedula_paci;
    

    $query1 = "UPDATE paciente SET cedula_paci = '$cedula_paci', 
    nombres_paci1 = '$nombres_paci1', 
    apellidos_paci1 = '$apellidos_paci1',
    nombres_paci2 = '$nombres_paci2', 
    apellidos_paci2 = '$apellidos_paci2',
    fechan_paci = '$fechan_paci',  
    telefono_paci = '$telefono_paci', 
    celular_paci = '$celular_paci', 
    contacto_nom = '$contacto_nom',
    contacto_ape = '$contacto_ape',
    contacto_num = '$contacto_num',
    contacto_par = '$contacto_par',
    gen_id = '$gen_id',
    contacto_dir = '$contacto_dir',
    direccion_paci = '$direccion_paci',
    ocupacion_paci = '$ocupacion_paci',
    empresat_paci = '$empresat_paci'
    WHERE id_paciente = '$id_paciente'";
    $query2 = "UPDATE usuario SET usuario = '$usuario' WHERE id_usuario = '$id_usuario'";
    
    $result1 = mysqli_query($conn, $query1);
    $result2 = mysqli_query($conn, $query2);

    $result = $result1." ".$result2;

    if (!$result) {
    die('Actualización Fallida');
    }
    echo "Datos del paciente actualizados satisfactoriamente"; 


?>
