<?php
include_once("../sesion.php");
include_once("../variables.php");
if (trim($_SESSION['rol']) != trim($medi)) {
    echo"<script>window.location.replace('../index.php');</script>";
}
?>
<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Perfil Médico</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/medi.css">


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
</head>

<body class="sidebar-menu-collapsed">
    <div class="se-pre-con"></div>
    <section>
       <?php include_once("nav.php") ?>
        <!-- main content start -->
        <div class="main-content">

            <!-- content -->
            <div class="container-fluid content-top-gap">
                <div class="d-flex justify-content-center">
                    <div class="col-xl-12 col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-3 bg-c-lite-green user-profile abs-center">
                                    <div class="card-block text-center text-white">
                                        <h6 hidden id="id_medico">Aquí va el ID</h6>
                                        <div class="m-b-25">
                                            <img id="imagen" src="" width="175" height="175" class="rounded-circle" alt="User-Profile-Image">
                                        </div>
                                        <h6 class="f-w-600 my-2 text-uppercase" id="nom_card"></h6>
                                        <p class="my-1 text-uppercase" id="rol_card">médico</p>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit">DATOS PERSONALES</h6>
                                        <div class="row">
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Nombres:</p>
                                                <h6 class="text-muted f-w-400" id="nombres_medi"></h6>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Apellidos:</p>
                                                <h6 class="text-muted f-w-400" id="apellidos_medi"></h6>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Cédula:</p>
                                                <p class="text-muted f-w-400" id="cedula_medi"></p>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Teléfono:</p>
                                                <h6 class="text-muted f-w-400" id="telefono_medi">N/A</h6>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Celular:</p>
                                                <h6 class="text-muted f-w-400" id="celular_medi"></h6>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Correo:</p>
                                                <h6 class="text-muted f-w-400" id="correo_medi"></h6>
                                            </div>
                                            <div class="col-sm-12 my-2">
                                                <p class="m-b-10 f-w-600">Dirección:</p>
                                                <h6 class="text-muted f-w-400" id="direccion_medi"></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <!-- //content -->
        </div>
        <!-- main content end-->
    </section>



    <!----------------------------------------------------------------------------footer section start--------------------------------------------------------->
    <?php include_once("footer.php") ?>
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
    <script src="js/medi.js"></script>

    <script src="js/perfil.js"></script>

</body>

</html>