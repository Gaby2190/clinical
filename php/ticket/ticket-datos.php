<?php
include_once '../../dbconnection.php';
$id_cita = $_POST['id_cita'];

$query = "SELECT cp.descripcion, cp.costo, fp.nombre, tp.descripcion as tipo_pago
            FROM `cita_pago` AS cp
            INNER JOIN f_pago as fp
            ON cp.id_f_pago = fp.id
            INNER JOIN tipo_pago AS tp
            ON tp.id_tipo_pago = cp.id_tipo_pago
            WHERE `id_cita` =  $id_cita";


$result = mysqli_query($conn, $query);

if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
}

$json = array();
while($row = mysqli_fetch_array($result)) {
    $json[] = array(
        'descripcion' => $row['descripcion'],
        'costo' => $row['costo'],
        'tipo_pago' => $row['tipo_pago'],
        'nombre' => $row['nombre']
    );
}

if (empty($json)) {
    echo false;
}else{
$jsonstring = json_encode($json);
echo $jsonstring;
}

?>