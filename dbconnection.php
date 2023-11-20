<?php
$servername = "localhost";
$database = "cesmedec_clinical";
//$username = "cesmedec_clinical";
//$password = "Cesmed1994*";

$username = "root";
$password = "";

// Crear conexiиоn
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8");
// Verificar Conexiиоn 
if (!$conn) {
    die("Conexиоn fallida: " . mysqli_connect_error());
}

?>