<?php
include_once ("../sesion.php"); //Configuración de la duración e inicio de sesión
include_once ("../dbconnection.php"); //Configuración de los datos de conexión a la base de datos
include_once ("../variables.php"); // definición de las variables globales
if (isset($_GET['cerrar_sesion'])) { //Recibe "cerrar_sesion" y evalua si se debe destruir la sesión
    session_unset();// Limpia la sesión
    session_destroy();// Destruye la sesión
   echo"<script>window.location.replace('../index.php');</script>";//redirecciona al pagina inicial del sistema
}
else // Cuando "cerrar_sesion" es null
{
    if (isset($_SESSION['rol'])) { //Recibe y evalua si "rol" en sesion tenga un contenido
        switch ($_SESSION['rol']) { //Si "rol" tiene un valor lo compara, y redirige.
            case $admin:
                echo"<script>window.location.replace('../admin/admin.php');</script>";
                break;
            case $rece:
                echo"<script>window.location.replace('../recepcionista/rece.php');</script>";
                break;
            case $paci:
                echo"<script>window.location.replace('../paciente/paci.php');</script>";
                break;
            case $medi:
                echo"<script>window.location.replace('../medico/medi.php');</script>";
                break;
            case $caje:
                echo"<script>window.location.replace('../cajero/caje.php');</script>";
                break;
            case $asis:
                echo"<script>window.location.replace('../asistente/asis.php');</script>";
                break;
        } 
    }
    elseif (isset($_POST['usuario']) && isset($_POST['password'])) {//recibe y evalua "usuario" y "password"
       $usr = mysqli_real_escape_string($conn,$_POST['usuario']);//escapa almacena en usr el valor del POST usuario
       $pass = $_POST['password'];// almacena en pass el valor del POST password
       $query = "SELECT u.*, r.nombre 
                FROM usuario AS u 
                INNER JOIN rol AS r 
                ON r.id = u.id_rol 
                WHERE u.usuario = '$usr'";//Consulta SQL seleccionando los datos si existe el usuario logeado
        $result = mysqli_query($conn, $query);//Ejecuta la consulta y almacena el resultado en result
        $nusr = mysqli_num_rows($result);// Obtiene el numero de filas del resultado y guarda en nusr
        $dato_usr = mysqli_fetch_array($result);//Guarda en resultado en un formato array y lo guarda en dato_usr
         if (($nusr == 1) && (password_verify($pass,$dato_usr['clave']))) {//evalua que nusr sea 1 y que las claves sean iguales
            $rol = $dato_usr['id_rol']; //Define rol y toma el valor del dato_usr.id_rol
            $id_usuario = $dato_usr['id_usuario'];//Define id_usuario y toma el valor del dato_usr.id_usuario 
            $_SESSION['id_usuario'] = $id_usuario;//Define Sesion.id_usuario y asigna el valor de id_usuario
            $_SESSION['rol'] = $rol; //Define en sesion.rol y asegina el valor de rol
            switch ($_SESSION['rol']) {//Compara el rol con las variables globales y redirige.
               case $admin:
            echo"<script>window.location.replace('../admin/admin.php');</script>";
                break;
            case $rece:
                echo"<script>window.location.replace('../recepcionista/rece.php');</script>";
                break;
            case $paci:
                echo"<script>window.location.replace('../paciente/paci.php');</script>";
                break;
            case $medi:
                echo"<script>window.location.replace('../medico/medi.php');</script>";
                break;
            case $caje:
                echo"<script>window.location.replace('../cajero/caje.php');</script>";
                break;
            case $asis:
                echo"<script>window.location.replace('../asistente/asis.php');</script>";
                break;
            } 
        }else{// cuando al contraseña no coindice o nusr no es 1
            echo "<script>$(#modalPush).modal('show')</script>";
            echo "Usuario o contraseña incorrectos";
        }
    }
}// Cuando no ingrese en ninguna de las clausulas if, se procede a crear el formulario en HTML
?>
<!doctype html>
<html lang="es">
<head>
    <title>Inicio de Sesión</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/16c313bafd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="login.css">
</head>
<body> 
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: url(../assets/images/principal_cesmed.jpeg);">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4 text-center">Acceder</h3>
                                </div>
                            </div>
                            <form class="signin-form" id="login-form" action="#" method="POST">
                                <div class="form-group mb-3">
                                    <label class="label" for="name">Nombre de usuario</label>
                                    <input type="text" class="form-control" placeholder="Usuario" required name="usuario">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">Contraseña</label>
                                    <input type="password" class="form-control" placeholder="Contraseña" required name="password">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded px-3">Acceder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal: INFORMACION-->
        <div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">
                        <div class="modal-content text-center">
                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Información</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icon"></i>
                                <p id="texto_modal">  </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Modal: modalPush-->
    </section>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/popper.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
