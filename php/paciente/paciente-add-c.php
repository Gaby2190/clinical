<?php

include_once '../../dbconnection.php';

    $cedula_paci = $_POST['cedula_paci'];
    $nombres_paci1 = trim(mb_strtoupper($_POST['nombres_paci1']));
    $apellidos_paci1 = trim(mb_strtoupper($_POST['apellidos_paci1']));
    $nombres_paci2 = trim(mb_strtoupper($_POST['nombres_paci2']));
    $apellidos_paci2 = trim(mb_strtoupper($_POST['apellidos_paci2']));
    $celular_paci = $_POST['celular_paci'];
    $imagen = $_POST['imagen'];
    $nac_id = $_POST['nac_id'];
    $id_usuario = $_POST['id_usuario'];
    $id_seguro = $_POST['id_seguro'];

    $query = "INSERT into paciente(cedula_paci, nombres_paci1,apellidos_paci1,nombres_paci2,apellidos_paci2,celular_paci,imagen,nac_id,id_usuario, id_seguro) 
            VALUES ('$cedula_paci', '$nombres_paci1','$apellidos_paci1','$nombres_paci2','$apellidos_paci2','$celular_paci','$imagen','$nac_id','$id_usuario', '$id_seguro')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Paciente registrado exitosamente";  


?>
