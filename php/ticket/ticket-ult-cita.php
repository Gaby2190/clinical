<?php   
include_once '../../dbconnection.php';
$id_medico = $_POST['id_medico'];
$id_paciente = $_POST['id_paciente'];

$query ="SELECT MAX(ci.fecha) as ult_cita 
            FROM `caso` as ca 
            INNER JOIN cita as ci 
            ON ci.id_caso = ca.id_caso 
            WHERE id_medico=$id_medico and id_paciente = $id_paciente AND ci.id>3";
$result = mysqli_query($conn, $query);
if(!$result) {
    die('Error en consulta '.mysqli_error($conn));
  }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'ult_cita' => $row['ult_cita']
        );
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;

?>