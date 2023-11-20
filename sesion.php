<?php
define('DURACION_SESION','3600'); // 1hora
ini_set("session.cookie_lifetime",DURACION_SESION);
ini_set("session.gc_maxlifetime",DURACION_SESION); 

session_cache_expire(DURACION_SESION);

session_start();
?>