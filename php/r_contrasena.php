<?php
include_once '../dbconnection.php';
include_once '../variables.php';

if (isset($_POST['id_usuario']) && isset($_POST['cont_ant']) && isset($_POST['cont_new'])) {
    $id_usuario = $_POST['id_usuario'];
    $cont_ant = $_POST['cont_ant'];
    $cont_new = password_hash($_POST['cont_new'], PASSWORD_DEFAULT);


    //$db = new Database();
    $query = "SELECT u.*, r.nombre
    FROM usuario AS u 
    INNER JOIN rol AS r
        ON r.id = u.id_rol
    WHERE u.id_usuario = '{$id_usuario}'";

    $result = mysqli_query($conn, $query);
    $nusr = mysqli_num_rows($result);
    $dato_usr = mysqli_fetch_array($result);

    if (($nusr == 1) && (password_verify($cont_ant,$dato_usr['clave']))) {
        $query_cont = "UPDATE usuario SET clave = '$cont_new' WHERE id_usuario = '$id_usuario'";
        $result_cont = mysqli_query($conn, $query_cont);

        if(!$result_cont) {
            die('Error en consulta '.mysqli_error($conn));
        }

        echo "La contraseña se ha actualizado satisfactoriamente"; 
    }else{
        echo false;
    }
}
?>