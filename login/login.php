<?php
include_once("../sesion.php");
include_once("../dbconnection.php");
include_once("../variables.php");

if (isset($_GET['cerrar_sesion'])) {
    session_unset();
    session_destroy();
   echo"<script>window.location.replace('../index.php');</script>";
}
else
{    
    if (isset($_SESSION['rol'])) {
        switch ($_SESSION['rol']) {
            case $admin:
                echo "Ingresa a menu administrador";
              //  header("Location: ../admin/admin.php");
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
    
    elseif (isset($_POST['usuario']) && isset($_POST['password'])) {
       $usr = $_POST['usuario'];
       $pass = $_POST['password'];
    
        //$db = new Database();
        $query = "SELECT u.*, r.nombre
        FROM usuario AS u 
        INNER JOIN rol AS r
            ON r.id = u.id_rol
        WHERE u.usuario = '{$usr}'";
    
        $result = mysqli_query($conn, $query);
        $nusr = mysqli_num_rows($result);
        $dato_usr = mysqli_fetch_array($result);
    
        if (($nusr == 1) && (password_verify($pass,$dato_usr['clave']))) {
            $rol = $dato_usr['id_rol'];
            $id_usuario = $dato_usr['id_usuario'];
            $_SESSION['id_usuario'] = $id_usuario;
            $_SESSION['rol'] = $rol;
            switch ($_SESSION['rol']) {
               case $admin:
                echo "Ingresa a menu administrador";
              //  header("Location: ../admin/admin.php");
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
        }else{
            echo "<script>$(#modalPush).modal('show')</script>";
            echo "Usuario o contraseña incorrectos";
        }
    }
}?>
<!doctype html>
<html lang="es">

<head>
    <title>Inicio de Sesión</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <!-- <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet"> -->

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
