<?php

//Configuración de la base de datos 
$servername = "localhost";
$database = "cesmedec_clinical";
$username = "root";
$password = "";

// Crear conexi��n con la extención mysqli
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8");
// Verificar Conexi��n 
if (!$conn) {
    die("Conex��n fallida: " . mysqli_connect_error());
}

?>