<?php

include_once '../../dbconnection.php';
include_once '../../variables.php';


    $query = "SELECT pa.*, me.sufijo, me.apellidos_medi, me.nombres_medi, usu.id_rol
              FROM pago as pa
              INNER JOIN medico as me
                ON pa.id_medico = me.id_medico
              INNER JOIN usuario as usu
                ON pa.id_usuario = usu.id_usuario ORDER BY pa.id_pago DESC";
    
    $result = mysqli_query($conn, $query);
    if(!$result) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    function usrNomApe($id_rol, $id_usuario){
      global $admin;
      global $rece;
      global $paci;
      global $medi;
      global $caje;
      global $conn;
        $nombres = "";
        $apellidos = "";
        switch (floatval($id_rol)) {
            case $admin:
              $query_admin = "SELECT * FROM administrador WHERE id_usuario = '{$id_usuario}'";
              $result_admin = mysqli_query($conn, $query_admin);
              while($row = mysqli_fetch_array($result_admin)) {
                  $nombres = $row['nombres_admin'];
                  $apellidos = $row['apellidos_admin'];
              }
              break;
            case $rece:
              $query_rece = "SELECT * FROM recepcionista WHERE id_usuario = '{$id_usuario}'";
              $result_rece = mysqli_query($conn, $query_rece);
              while($row = mysqli_fetch_array($result_rece)) {
                  $nombres = $row['nombres_rece'];
                  $apellidos = $row['apellidos_rece'];
              }
              break;
            case $medi:
              $query_medi = "SELECT * FROM medico WHERE id_usuario = '{$id_usuario}'";
              $result_medi = mysqli_query($conn, $query_medi);
              while($row = mysqli_fetch_array($result_medi)) {
                  $nombres = $row['nombres_medi'];
                  $apellidos = $row['apellidos_medi'];
              }
              break;
            case $caje:
              $query_caje = "SELECT * FROM cajero WHERE id_usuario = '{$id_usuario}'";
              $result_caje = mysqli_query($conn, $query_caje);
              while($row = mysqli_fetch_array($result_caje)) {
                  $nombres = $row['nombres_caje'];
                  $apellidos = $row['apellidos_caje'];
              }
              break;
        }
        return ($apellidos." ".$nombres);
    } 
    

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'id_pago' => $row['id_pago'],
        'fecha_gen' => $row['fecha_gen'],
        'usuario' => usrNomApe($row['id_rol'], $row['id_usuario']),
        'id_usuario' => $row['id_usuario'],
        'id_medico' => $row['id_medico'],
        'valor_total' => $row['valor_total'],
        'sufijo' => $row['sufijo'],
        'apellidos_medi' => $row['apellidos_medi'],
        'nombres_medi' => $row['nombres_medi']
        );
    }
  
    if (empty($json)) {
        echo false;
      }else{
        $jsonstring = json_encode($json);
        echo $jsonstring;
      }
?>
