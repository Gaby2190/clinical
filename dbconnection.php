<?php
$servername = "localhost";
$database = "cesmedec_clinical";
$username = "root";
$password = "";

// Crear conexi��n
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8");
// Verificar Conexi��n 
if (!$conn) {
    die("Conexion fallida: " . mysqli_connect_error());
}
?>