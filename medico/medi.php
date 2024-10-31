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

    <title>MÉDICO</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/medi.css">


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
                            <h1>Hola <span class="text-primary" id="name_medi"></span>, Bienvenido de nuevo!</h1>
                            <p>Dashboard - Médico</p>
                        </div>

                        <!-- statistics data -->
                        <div class="statistics">
                            <div class="row">
                                <div class="col-xl-12 pr-xl-2">
                                    <div class="row">
                                        <div class="col-sm-4 pl-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="lnr lnr-users"> </i>
                                                <h3 class="text-danger number" id="total_se"></h3>
                                                <p class="stat-text"><a href="sala_espera.php"> CITAS EN SALA DE ESPERA</a></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pl-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="lnr lnr-calendar-full"> </i>
                                                <h3 class="text-primary number" id="total_cp"></h3>
                                                <p class="stat-text">TOTAL DE CITAS - AGENDADAS</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pl-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="lnr lnr-heart-pulse"> </i>
                                                <h3 class="text-success number" id="total_ca"></h3>
                                                <p class="stat-text">TOTAL DE CITAS - ATENDIDAS</p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 pl-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="lnr lnr-smile"> </i>
                                                <h3 class="text-danger number" id="total_cc"></h3>
                                                <p class="stat-text">TOTAL DE CITAS - COBRADAS</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pl-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="lnr lnr-file-empty"> </i>
                                                <h3 class="text-primary number" id="total_ca_a"></h3>
                                                <p class="stat-text">TOTAL DE CASOS - ABIERTOS</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pl-sm-2 statistics-grid">
                                            <div class="card card_border border-primary-top p-4">
                                                <i class="lnr lnr-paperclip"> </i>
                                                <h3 class="text-success number" id="total_ca_c"></h3>
                                                <p class="stat-text">TOTAL DE CASOS - CERRADOS</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- modals -->
                        <section class="template-cards">
                            <div class="card card_border">
                                <div class="cards__heading">
                                    <h3>CITAS AGENDADAS, REAGENDADAS Y PENDIENTES DE COBRO</span></h3>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-lg-6 pr-lg-2 chart-grid">
                                            <div class="card text-center card_border">
                                                <div class="card-header chart-grid__header">
                                                    Citas agendadas y reagendadas
                                                </div>
                                                <div class="card-body">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary btn-style" id="citas_ar">
                                                        MOSTRAR
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 chart-grid">
                                            <div class="card text-center card_border">
                                                <div class="card-header chart-grid__header">
                                                    Citas pendientes de Cobro
                                                </div>
                                                <div class="card-body">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary btn-style" id="citas_pc">
                                                    MOSTRAR
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        
                        
                        <div class="modal fade" id="modalCAR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 1100px!important;" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <h4 class="modal-title w-100 font-weight-bold">Citas Agendadas y Reagendadas</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body mx-3">
                                        <div class="table-responsive">
                                            <table class="table" id="tabla_pac">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" hidden>ID</th>
                                                        <th scope="col">Nombres y Apellidos</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Hora</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_citasar"> </tbody>
                                            </table>
                                            <div class="col-md-12 text-center">
                                                <ul class="pagination pager" id="myPager"></ul>
                                            </div>
                                        </div>
        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade" id="modalCPC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 1100px!important;" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <h4 class="modal-title w-100 font-weight-bold">Citas Pendientes de Cobro</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body mx-3">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" hidden>ID</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Hora</th>
                                                        <th scope="col">Paciente</th>
                                                        <th scope="col">Consulta</th>
                                                        <th scope="col">Tarifa</th>
                                                        <th scope="col">Descuento</th>
                                                        <th scope="col">Adicionales</th>
                                                        <th scope="col">Otros</th>
                                                        <th scope="col">Total Cobrado</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_citaspc"> </tbody>
                                            </table>
                                            <div class="col-md-12 text-center">
                                                <ul class="pagination pager" id="myPager"></ul>
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
    <script src="js/medi.js"></script>

</body>

</html>