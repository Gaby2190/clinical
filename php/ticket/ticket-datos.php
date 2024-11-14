<?php
include_once '../../dbconnection.php';
$id_cita = $_POST['id_cita'];

$query = "SELECT cp.descripcion, cp.costo, fp.nombre
            FROM `cita_pago` AS cp
            INNER JOIN f_pago as fp
            ON cp.id_f_pago = fp.id
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