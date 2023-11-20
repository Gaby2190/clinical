<?php

    include('../../dbconnection.php');
    include('../../variables.php');

    $cedula_paci = $_POST['cedula_paci'];
    $nombres_paci1 = trim(mb_strtoupper($_POST['nombres_paci1']));
    $apellidos_paci1 = trim(mb_strtoupper($_POST['apellidos_paci1']));
    $nombres_paci2 = trim(mb_strtoupper($_POST['nombres_paci2']));
    $apellidos_paci2 = trim(mb_strtoupper($_POST['apellidos_paci2']));
    $fechan_paci = $_POST['fechan_paci'];
    $telefono_paci = $_POST['telefono_paci'];
    $celular_paci = $_POST['celular_paci'];
    $correo_paci = $_POST['correo_paci'];
    $direccion_paci = mb_strtoupper($_POST['direccion_paci']);
    $imagen = $_POST['imagen'];
    $contacto_nom = mb_strtoupper($_POST['contacto_nom']);
    $contacto_ape = mb_strtoupper($_POST['contacto_ape']);
    $contacto_num = mb_strtoupper($_POST['contacto_num']);
    $contacto_par = mb_strtoupper($_POST['contacto_par']);
    $san_id = $_POST['san_id'];
    $nac_id = $_POST['nac_id'];
    $gen_id = $_POST['gen_id'];
    $barrio_paci = mb_strtoupper($_POST['barrio_paci']);
    $parroquia_paci = mb_strtoupper($_POST['parroquia_paci']);
    $canton_paci = mb_strtoupper($_POST['canton_paci']);
    $provincia_paci = mb_strtoupper($_POST['provincia_paci']);
    $zona_paci = $_POST['zona_paci'];
    $lnacimiento_paci = mb_strtoupper($_POST['lnacimiento_paci']);
    $gcultural_paci = $_POST['gcultural_paci'];
    $ecivil_paci = $_POST['ecivil_paci'];
    $instruccion_paci = mb_strtoupper($_POST['instruccion_paci']);
    $ocupacion_paci = mb_strtoupper($_POST['ocupacion_paci']);
    $empresat_paci = mb_strtoupper($_POST['empresat_paci']);
    $ssalud_paci = mb_strtoupper($_POST['ssalud_paci']);
    $referido_paci = mb_strtoupper($_POST['referido_paci']);
    $contacto_dir = mb_strtoupper($_POST['contacto_dir']);
    $id_usuario = $_POST['id_usuario'];


    $query = "INSERT into paciente(cedula_paci, nombres_paci1,apellidos_paci1,nombres_paci2,apellidos_paci2,fechan_paci,telefono_paci,celular_paci,correo_paci,direccion_paci,imagen, contacto_nom, contacto_ape, contacto_num, contacto_par,san_id,nac_id,gen_id,id_usuario,barrio_paci,parroquia_paci,canton_paci,provincia_paci,zona_paci,lnacimiento_paci,gcultural_paci,ecivil_paci,instruccion_paci,ocupacion_paci,empresat_paci,ssalud_paci,referido_paci,contacto_dir) 
            VALUES ('$cedula_paci', '$nombres_paci1','$apellidos_paci1','$nombres_paci2','$apellidos_paci2','$fechan_paci','$telefono_paci','$celular_paci','$correo_paci','$direccion_paci','$imagen','$contacto_nom', '$contacto_ape', '$contacto_num', '$contacto_par','$san_id','$nac_id','$gen_id','$id_usuario','$barrio_paci','$parroquia_paci','$canton_paci','$provincia_paci','$zona_paci','$lnacimiento_paci','$gcultural_paci','$ecivil_paci','$instruccion_paci','$ocupacion_paci','$empresat_paci','$ssalud_paci','$referido_paci','$contacto_dir')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Consulta Fallida');
    }

    echo "Paciente registrado exitosamente";  


?>
