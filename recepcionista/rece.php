<?php
include_once("../sesion.php");
include_once("../variables.php");
if (trim($_SESSION['rol']) != trim($rece)) {
    echo"<script>window.location.replace('../index.php');</script>";
} 
?>
<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>RECEPCIONISTA</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/rece.css">


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
                            <h1>Hola <span class="text-primary" id="nom_usr_dash"></span></h1>
                            <p>Es un placer tenerle de regreso.</p>
                        </div>

                        <!-- statistics data -->
                        <div class="statistics">
                            <div class="row">
                                <div class="col-xl-6 pr-xl-2">
                                    <div class="row">
                                        <div class="col-sm-6 pr-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="lnr lnr-calendar-full"> </i>
                                                <h3 class="text-primary number" id="total_cp"></h3>
                                                <p class="stat-text">Citas Agendadas</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="lnr lnr-users"> </i>
                                                <h3 class="text-secondary number" id="total_sala"></h3>
                                                <p class="stat-text">En sala de Espera</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 pl-xl-2">
                                    <div class="row">
                                        <div class="col-sm-6 pr-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="lnr lnr-arrow-up-circle"> </i>
                                                <h3 class="text-success number" id="cobrar"></h3>
                                                <p class="stat-text">Por Cobrar</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="lnr lnr-arrow-down-circle"> </i>
                                                <h3 class="text-danger number" id="pagar"></h3>
                                                <p class="stat-text">Por Pagar</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                      

                        <!-- modals -->
                        <section class="template-cards">
                            <div class="card card_border">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        
                                        <div class="col-lg-4 pr-lg-2 chart-grid">
                                            <div class="card text-center card_border">
                                                <div class="card-header chart-grid__header">
                                                    Agenda Medicos
                                                </div>
                                                <div class="card-body">
                                                    <!-- Button trigger modal -->
                                                    <a  href="cita_age_doc_n.php" class="btn btn-primary btn-style">Mostrar</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 pr-lg-2 chart-grid">
                                            <div class="card text-center card_border">
                                                <div class="card-header chart-grid__header">
                                                    Citas Agendadas
                                                </div>
                                                <div class="card-body">
                                                    <!-- Button trigger modal -->
                                                    <a href="cita_age_read.php" class="btn btn-primary btn-style">Mostrar</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 pr-lg-2 chart-grid">
                                            <div class="card text-center card_border">
                                                <div class="card-header chart-grid__header">
                                                    Cobrar Citas
                                                </div>
                                                <div class="card-body">
                                                    <!-- Button trigger modal -->
        <a href="c_pendientes.php" class="btn btn-primary btn-style">Mostrar</a>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </section>
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
            $(".se-pre-con").fadeOut("slow");
        });
    </script>
    <!--// loading-gif Js -->

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="js/rece.js"></script>

</body>

</html>