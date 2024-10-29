<?php
define('DURACION_SESION','3600'); // 1hora
ini_set("session.cookie_lifetime",DURACION_SESION);
ini_set("session.gc_maxlifetime",DURACION_SESION); 
ini_set("session.save_path","/tmp");
session_cache_expire(DURACION_SESION);
session_start();
session_regenerate_id(true);
?>