<?php
include_once '../../dbconnection.php';
$id_cita = $_POST['id_cita'];
$query = "SELECT ci.*, 
            ca.id_medico, 
            me.sufijo, me.apellidos_medi , 
            me.nombres_medi, me.nom_ape_medi, me.pago_ingreso, me.tarifa, me.tarifa_control, 
            pa.nombres_paci1, pa.nombres_paci2, pa.apellidos_paci1, pa.apellidos_paci2, pa.id_paciente
            FROM cita AS ci
            INNER JOIN caso AS ca
                ON ci.id_caso = ca.id_caso
            INNER JOIN medico as me
                ON ca.id_medico = me.id_medico
            INNER JOIN paciente as pa
                ON ca.id_paciente = pa.id_paciente
            WHERE ci.id_cita = '{$id_cita}'";


$result = mysqli_query($conn, $query);

if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
}

$json = array();
while($row = mysqli_fetch_array($result)) {
    $json[] = array(
        'id_cita' => $row['id_cita'],
        'descripcion' => $row['descripcion'],
        'fecha' => $row['fecha'],
        'hora' => $row['hora'],
        'tipo_cita' => $row['tipo_cita'],
        'id' => $row['id'],
        'id_caso' => $row['id_caso'],
        'id_medico' => $row['id_medico'],
        'nombres_medi' => $row['nombres_medi'],
        'apellidos_medi' => $row['apellidos_medi'],
        'pago_ingreso' => $row['pago_ingreso'],
        'tarifa' => $row['tarifa'],
        'tarifa_control' => $row['tarifa_control'],
        'nombres_paci1' => $row['nombres_paci1'],
        'apellidos_paci1' => $row['apellidos_paci1'],
        'nombres_paci2' => $row['nombres_paci2'],
        'apellidos_paci2' => $row['apellidos_paci2'],
        'sufijo' => $row['sufijo'],
        'nom_ape_medi' => $row['nom_ape_medi'],
        'id_paciente' => $row['id_paciente']
        
    );
}

$jsonstring = json_encode($json[0]);
echo $jsonstring;

?>