<<<<<<< HEAD
<?php
define('DURACION_SESION','3600'); // 1hora
ini_set("session.cookie_lifetime",DURACION_SESION);
ini_set("session.gc_maxlifetime",DURACION_SESION); 

session_cache_expire(DURACION_SESION);

session_start();
=======
<?php
define('DURACION_SESION','3600'); // 1hora
ini_set("session.cookie_lifetime",DURACION_SESION);
ini_set("session.gc_maxlifetime",DURACION_SESION); 

session_cache_expire(DURACION_SESION);

session_start();
>>>>>>> c5c15f1562fb2ea6cff3f892727885527cf2b0ec
?>