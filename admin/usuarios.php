<?php
include_once("../sesion.php");
include_once("../variables.php"); 
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

    <title>Usuarios</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/admin.css">


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
</head>

<body class="sidebar-menu-collapsed">

    <section> 
       <?php include_once("nav.php") ?>
        <!-- main content start -->
        <div class="main-content">

        <!-- content -->
            <div class="container-fluid content-top-gap">
                <div class="d-flex justify-content-center">
                    <div class="col-xl-12 col-md-12">

                        <div class="welcome-msg pt-3 pb-4">
                            <h1>ADMINISTRACI&Oacute;N DE USUARIOS</h1>
                        </div>

                        <!-- statistics data -->
                        <div class="statistics">
                            <div class="row">
                                <div class="col-xl-12 pr-xl-2">
                                    <div class="row">
                                        <div class="col-sm-4 pr-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="fa fa-lock"> </i>
                                                <h3 class="text-primary number">ADMINISTRADOR</h3>
                                                <ul style="list-style:none; text-align: right;">
                                                    <li><a href="admin_create.php">-Registrar</a> </li>
                                                    <li><a href="admin_read.php">-Actualizar</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pr-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="fa fa-group"> </i>
                                                <h3 class="text-success number">PACIENTES</h3>
                                                <ul style="list-style:none; text-align: right;">
                                                    <li><a href="paci_create.php">-Registrar</a> </li>
                                                    <li><a href="paci_read.php">-Actualizar</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pl-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="fa fa-user-md"> </i>
                                                <h3 class="text-primary number">MÉDICOS</h3>
                                                <ul style="list-style:none; text-align: right;">
                                                    <li><a href="med_create.php">-Registrar</a> </li>
                                                    <li><a href="med_read.php">-Actualizar</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 pr-xl-2">
                                    <div class="row">
                                        <div class="col-sm-4 pr-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="fa fa-id-card"> </i>
                                                <h3 class="text-danger number">RECEPCIONISTAS</h3>
                                                <ul style="list-style:none; text-align: right;">
                                                    <li><a href="rece_create.php">-Registrar</a> </li>
                                                    <li><a href="rece_read.php">-Actualizar</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pr-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="fa fa-money"> </i>
                                                <h3 class="text-secondary number">CAJEROS</h3>
                                                <ul style="list-style:none; text-align: right;">
                                                    <li><a href="caje_create.php">-Registrar</a> </li>
                                                    <li><a href="caje_read.php">-Actualizar</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pl-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="fa fa-user-circle"> </i>
                                                <h3 class="text-primary number">ASISTENTES</h3>
                                                <ul style="list-style:none; text-align: right;">
                                                    <li><a href="asis_create.php">-Registrar</a> </li>
                                                    <li><a href="asis_read.php">-Actualizar</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>  
        </div>
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
    <script src="js/admin.js"></script>

</body>

</html>