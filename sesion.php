<?php
define('DURACION_SESION','3600'); // 1hora
ini_set("session.cookie_lifetime",DURACION_SESION);
ini_set("session.gc_maxlifetime",DURACION_SESION); 

session_cache_expire(DURACION_SESION);

session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jan 1900 05:00:00 GMT"); // Indicamos una fecha en el pasado
?>