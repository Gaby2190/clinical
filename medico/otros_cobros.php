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

    <title>Otros Cobros</title>


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
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Otros cobros</h6>
                                        <input type="text" id="id_cita" value="<?php echo($id_cita);?>" required hidden>
                                        <div class="card-block">                                         
                                            <div class="col-12 table-responsive">
                                                <table class=" table table-striped" id="otros_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Descripción</th>
                                                            <th scope="col">Costo ($)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="otros_body"></tbody>
                                                </table>
                                                <a class="btn btn-secondary" data-toggle="modal" style="color: #fff" data-target="#modalOtros"><span class="fa fa-plus"></span> Añadir</a>
                                                <a href="caja.php" class="btn btn-primary" style="color: #fff"><span class="fa fa-arrow-left"></span> Regresar</a>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
 

                <!--Modal: modalPush-->
                <div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">
                        <!--Content-->
                        <div class="modal-content text-center">
                            <!--Header-->
                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Información</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>


                            <!--Body-->
                            <div class="modal-body">

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icon"></i>

                                <p id="texto_modal"></p>

                            </div>

                            <!--Footer-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div>
                        <!--/.Content-->
                    </div>
                </div>
                <!--Modal: modalPush-->

                <!--Modal: Adicionales-->
                <div class="modal fade" id="modalOtros" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Otros</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Descripción:</p>
                                    <textarea id="descripcion" class="form-control validate" size="255" maxlength="255" rows="4" required></textarea>
                                </div>

                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Costo:</p>
                                    <input placeholder="Dólares ($)" step="any" type="number" class="text-muted f-w-400 form-control" id="costo" required>
                                </div>

                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-primary" id="add_otros" data-dismiss="modal">Añadir</button>
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

    <script src="js/otros_cobros.js"></script>

</body>

</html>