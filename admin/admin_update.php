<?php
include_once "../sesion.php";
include_once "../variables.php";
header("Content-Type: text/plain");
if (trim($_SESSION['rol']) != trim($admin)) {
    echo"<script>window.location.replace('../index.php');</script>";
}
?>
<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Actualizar Perfil de Administrador</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/admin_update.css">


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
</head>

<body class="sidebar-menu-collapsed">
    <section>
       <?php include_once "nav.php"; ?>
        <!-- main content start -->
        <div class="main-content">
        <?php
        $id_administrador=$_GET['id_administrador'];
        $id_usuario=$_GET['id_usuario'];
        ?>
            <!-- content -->
            <div class="container-fluid content-top-gap">
                <div class="d-flex justify-content-center">
                    <div class="col-xl-12 col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-3 bg-c-lite-green user-profile abs-center">
                                    <div class="card-block text-center text-white">
                                        <h6 hidden id="id_administrador"></h6>
                                        <div class="m-b-25">
                                            <img id="imagen" src="" width="175" height="175" class="rounded-circle" alt="User-Profile-Image">
                                        </div>
                                        <h5 class="f-w-600 text-uppercase" id="nom_ape_card"></h5>
                                        <div class="my-3">
                                            <i class="fa fa-circle" style="color: green" id="stat"></i>
                                            <div class="m-l-20">
                                                <h7 id="estado_admin" class="my-1"></h7>
                                            </div>
                                            <div class="row my-1  justify-content-center">
                                                <button class="btn btn-secondary rounded btn-sm" id="btn_stat">Cambiar estado</button>
                                            </div>
                                        </div>
                                        <div class="justify-content-center">
                                            <button class="btn rounded" id="btn_rpass"><span class="fa fa-refresh"></span> Resetear contraseña</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">DATOS PERSONALES - administrador</h6>
                                        <div class="row">
                                        <input type="text" id="id_admin" value="<?php echo($id_administrador);?>" required hidden>
                                        <input type="text" id="id_usu" value="<?php echo($id_usuario);?>" required hidden>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Nombres:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="nombres_admin" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Apellidos:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="apellidos_admin" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Cédula:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="cedula_admin" ondrop=" return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="10" maxlength="10" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Teléfono:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="telefono_admin" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="15" maxlength="15">
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Celular:</p>
                                                <input type="tel" class="text-muted f-w-400 form-control" id="celular_admin" pattern="[0-9]{10}" size="10" maxlength="10" autocomplete="of" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Correo:</p>
                                                <input type="email" class="text-muted f-w-400 form-control" id="correo_admin" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Dirección:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="direccion_admin" size="100" maxlength="100" required>
                                            </div>
                                            <div class="col-sm-12 my-2 justify-content-right">
                                                <button class="btn btn-primary rounded float-right" id="btn_datos"><span class="fa fa-pencil-square-o"></span> ACTUALIZAR</button>
                                            </div>
                                        </div>
                                    </div>
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
                            <div class=" modal-body">

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icon"></i>

                                <p id="texto_modal"></p>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Modal: modalPush-->
            </div>
            <!-- //content -->
        </div>
        <!-- main content end-->
    </section>



    <!----------------------------------------------------------------------------footer section start--------------------------------------------------------->
    <?php include_once "footer.php"; ?>
    <!--footer section end-->


    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/jquery-1.10.2.min.js"></script>


    <script src="../assets/js/jquery.nicescroll.js"></script>
    <script src="../assets/js/scripts.js"></script>

    <script>
        var closebtns = document.getElementsByClassName("close-grid");
        var i;

        for (i = 0; i < closebtns.length; i++) {
            closebtns[i].addEventListener("click", function() {
                this.parentElement.style.display = 'none';
            });
        }
    </script>
    <!-- //close script -->

    <!-- disable body scroll when navbar is in active -->
    <script>

        $(function() {
            $('.sidebar-menu-collapsed').click(function() {
                $('body').toggleClass('noscroll');
            })
        });
    </script>
    <!-- disable body scroll when navbar is in active -->

    <!-- loading-gif Js -->
    <script src="../assets/js/modernizr.js"></script>
    <script>
        $(window).load(function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");;
        });
    </script>
    <!--// loading-gif Js -->

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="js/admin.js"></script>

    <script src="js/admin_update.js"></script>
    <script src="../lib/gen-pass.js"></script>

</body>

</html>