<?php 
include_once("../sesion.php");
include_once("../variables.php");
if (trim($_SESSION['rol']) != trim($admin)) {
    echo"<script>window.location.replace('../index.php');</script>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Reportes de la Cita</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/reporte_cita.css">


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
</head>
<body class="sidebar-menu-collapsed">
    <section>
        <?php include_once("nav.php") ?>
        <!-- main content start -->
        <div class="main-content">
            <?php
            $id_cita=$_GET['id_cita']; 
            ?>
            <!-- content -->
            <div class="container-fluid content-top-gap">
                <div class="d-flex justify-content-center">
                    <div class="col-xl-12 col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-12"> 
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Descargar reportes de la Cita</h6>
                                        <input type="text" id="id_cita" value="<?php echo($id_cita);?>" required hidden>
                                        <div class="row my-2">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-5 my-2">
                                                <p class="m-b-10 f-w-600" style="font-size: 20px">Receta Médica:</p>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <button class="btn btn-primary" id="desc_receta"><span class="fa fa-download"></span> DESCARGAR</button>
                                            </div>
                                            <div class="col-sm-2"></div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-5 my-2">
                                                <p class="m-b-10 f-w-600" style="font-size: 20px">Certificado Médico:</p>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <button class="btn btn-primary" id="desc_certmed"><span class="fa fa-download"></span> DESCARGAR</button>
                                            </div>
                                            <div class="col-sm-2"></div>
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
    <script src="js/admin.js"></script>

    <script src="js/reporte_cita.js"></script>

</body>

</html>